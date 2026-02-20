<?php

namespace Botble\Reviews\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Reviews\Tables\ReviewTable;
use Botble\Reviews\Models\Review;
use Illuminate\Http\Request;
use Botble\AiChatbot\Services\AiChatService;

class ReviewController extends BaseController
{
    public function index(ReviewTable $table)
    {
        $this->pageTitle('Quản lý đánh giá');

        return $table->renderTable();
    }

    public function destroy(Review $review, Request $request)
    {
        return DeleteResourceAction::make($review);
    }

    public function deletes(Request $request, \Botble\Base\Http\Responses\BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $review = Review::findOrFail($id);
            $review->delete();
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function analyze(int $id, AiChatService $aiService)
    {
        $review = Review::findOrFail($id);

        if ($review->rating > 3) {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ phân tích các đánh giá thấp (≤ 3 sao).',
            ]);
        }

        try {
            $reviewData = [
                'customer_name' => $review->member ? $review->member->name : $review->name,
                'rating' => $review->rating,
                'comment' => $review->comment ?? '(Không có nội dung)',
                'date' => $review->created_at ? $review->created_at->format('d/m/Y') : 'Không rõ',
            ];

            $analysis = $aiService->analyzeReview($reviewData);
            
            return response()->json([
                'success' => true,
                'data' => $analysis,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi phân tích AI: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Show review detail (read-only)
     */
    public function edit(Review $review)
    {
        $this->pageTitle('Chi tiết đánh giá #' . $review->id);

        // Load existing replies
        $replies = \DB::table('review_replies')
            ->leftJoin('members', 'review_replies.member_id', '=', 'members.id')
            ->where('review_id', $review->id)
            ->orderBy('review_replies.created_at', 'asc')
            ->select([
                'review_replies.*',
                \DB::raw("COALESCE(CONCAT(members.first_name, ' ', members.last_name), 'Quản trị viên') as replier_name"),
            ])
            ->get();

        return view('plugins/reviews::detail', compact('review', 'replies'));
    }

    /**
     * Admin reply to a review
     */
    public function reply(int $id, Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $review = Review::findOrFail($id);

        \DB::table('review_replies')->insert([
            'review_id' => $review->id,
            'member_id' => null, // null = admin reply
            'comment' => $request->input('comment'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('reviews.edit', $review->id)
            ->with('success_msg', 'Phản hồi đã được gửi thành công!');
    }

    /**
     * Delete a reply
     */
    public function destroyReply(int $id)
    {
        \DB::table('review_replies')->where('id', $id)->delete();

        return response()->json(['success' => true]);
    }
}
