<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RvMedia;

class ReviewController extends Controller
{
    /**
     * Get all approved reviews with pagination and filtering
     */
    public function index(Request $request)
    {
        // Only fetch top-level reviews (parent_id is null)
        $query = DB::table('reviews')
            ->where('is_approved', true)
            ->whereNull('parent_id');
        
        // Filter by rating
        if ($request->has('rating') && $request->rating !== 'all') {
            $query->where('rating', (int)$request->rating);
        }
        
        // Sorting
        $sortBy = $request->input('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'highest':
                $query->orderBy('rating', 'desc');
                break;
            case 'lowest':
                $query->orderBy('rating', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // Pagination
        $perPage = 5;
        $page = (int)$request->input('page', 1);
        $total = $query->count();
        $reviews = $query->skip(($page - 1) * $perPage)
                        ->take($perPage)
                        ->get();
        
        // Get voted reviews from DB or session
        $votedReviews = [];
        if (auth('member')->check()) {
            $votedReviews = DB::table('review_helpfuls')
                ->where('member_id', auth('member')->id())
                ->pluck('review_id')
                ->toArray();
        } else {
            $votedReviews = $request->session()->get('voted_reviews', []);
        }
        
        // Format dates and fetch replies for frontend
        // Format dates and fetch replies for frontend
        $reviews = $reviews->map(function ($review) use ($votedReviews) {
            $review->images = json_decode($review->images, true) ?? [];
            $review->date = \Carbon\Carbon::parse($review->created_at)->format('d/m/Y');
            
            // Check if voted
            $review->is_voted = in_array($review->id, $votedReviews);
            
            // Fetch replies from review_replies table
            $review->replies = DB::table('review_replies')
                ->leftJoin('members', 'review_replies.member_id', '=', 'members.id')
                ->where('review_id', $review->id)
                ->orderBy('review_replies.created_at', 'asc')
                ->select([
                    'review_replies.*',
                    DB::raw("COALESCE(CONCAT(members.first_name, ' ', members.last_name), 'Quản trị viên') as name"),
                    DB::raw("DATE_FORMAT(review_replies.created_at, '%d/%m/%Y') as date")
                ])
                ->get();
            
            return $review;
        });
        
        // Calculate stats (include all reviews for rating)
        $allReviews = DB::table('reviews')
            ->where('is_approved', true)
            ->whereNull('parent_id') // Only count parent reviews for stats
            ->get();
            
        $avgRating = $allReviews->avg('rating') ?? 0;
        $totalReviews = $allReviews->count();
        
        // Rating distribution
        $ratingCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingCounts[$i] = $allReviews->where('rating', $i)->count();
        }
        
        return response()->json([
            'reviews' => $reviews,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => ceil($total / $perPage),
            ],
            'stats' => [
                'average_rating' => round($avgRating, 1),
                'total_reviews' => $totalReviews,
                'rating_counts' => $ratingCounts,
            ],
        ]);
    }
    
    /**
     * Store a new review or reply
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'rating' => 'required_without:parent_id|integer|min:1|max:5',
            'comment' => 'required|string|max:5000',
            'images' => 'nullable|array|max:3',
            'images.*' => 'string', // Base64 or URLs
            'parent_id' => 'nullable|exists:reviews,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $memberId = null;
        if (auth('member')->check()) {
            $memberId = auth('member')->id();
        }
        
        // Process images if provided
        $imageUrls = [];
        if ($request->has('images') && is_array($request->images)) {
            foreach ($request->images as $imageData) {
                $imageUrls[] = $imageData;
            }
        }
        
        $parentId = $request->input('parent_id');
        
        // If it's a reply, store in review_replies table
        if ($parentId) {
            $replyId = DB::table('review_replies')->insertGetId([
                'review_id' => $parentId,
                'member_id' => $memberId,
                'comment' => $request->comment,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Reply submitted successfully',
                'review_id' => $replyId, // Frontend might expect review_id
            ], 201);
        }
        
        try {
            // Store as a new review
            $reviewId = DB::table('reviews')->insertGetId([
                'name' => $request->name,
                'member_id' => $memberId,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'images' => json_encode($imageUrls),
                'helpful' => 0,
                'is_approved' => true, // Auto-approve for now
                'created_at' => now(),
                'updated_at' => now(),
                // parent_id removed/ignored for new reviews
            ]);
            
            return response()->json([
                'message' => $parentId ? 'Reply submitted successfully' : 'Review submitted successfully',
                'review_id' => $reviewId,
            ], 201);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Review Store Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete a review
     */
    public function destroy($id)
    {
        if (!auth('member')->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $review = DB::table('reviews')->where('id', $id)->first();

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        // Check ownership
        if ($review->member_id !== auth('member')->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        DB::table('reviews')->where('id', $id)->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }

    /**
     * Delete a reply
     */
    public function deleteReply($id)
    {
        if (!auth('member')->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $reply = DB::table('review_replies')->where('id', $id)->first();

        if (!$reply) {
            return response()->json(['message' => 'Reply not found'], 404);
        }

        // Check ownership
        if ($reply->member_id !== auth('member')->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        DB::table('review_replies')->where('id', $id)->delete();

        return response()->json(['message' => 'Reply deleted successfully']);
    }
    
    /**
     * Mark a review as helpful
     */
    public function helpful($id, Request $request)
    {
        // Handle for logged-in members (Database)
        if (auth('member')->check()) {
            $memberId = auth('member')->id();
            
            $exists = DB::table('review_helpfuls')
                ->where('review_id', $id)
                ->where('member_id', $memberId)
                ->exists();
                
            if ($exists) {
                // Remove vote
                DB::table('review_helpfuls')
                    ->where('review_id', $id)
                    ->where('member_id', $memberId)
                    ->delete();
                DB::table('reviews')->where('id', $id)->decrement('helpful');
                $voted = false;
            } else {
                // Add vote
                DB::table('review_helpfuls')->insert([
                    'review_id' => $id,
                    'member_id' => $memberId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('reviews')->where('id', $id)->increment('helpful');
                $voted = true;
            }
            
            $helpful = DB::table('reviews')->where('id', $id)->value('helpful');
            
            return response()->json([
                'message' => $voted ? 'Vote added' : 'Vote removed',
                'helpful' => $helpful,
                'voted' => $voted,
            ]);
        }

        // Fallback for guests (Session)
        $votedReviews = $request->session()->get('voted_reviews', []);
        
        if (in_array($id, $votedReviews)) {
            // Already voted, remove vote
            DB::table('reviews')->where('id', $id)->decrement('helpful');
            $votedReviews = array_diff($votedReviews, [$id]);
            $request->session()->put('voted_reviews', array_values($votedReviews));
            
            $helpful = DB::table('reviews')->where('id', $id)->value('helpful');
            
            return response()->json([
                'message' => 'Vote removed',
                'helpful' => $helpful,
                'voted' => false,
            ]);
        } else {
            // Add vote
            DB::table('reviews')->where('id', $id)->increment('helpful');
            $votedReviews[] = $id;
            $request->session()->put('voted_reviews', $votedReviews);
            
            $helpful = DB::table('reviews')->where('id', $id)->value('helpful');
            
            return response()->json([
                'message' => 'Vote added',
                'helpful' => $helpful,
                'voted' => true,
            ]);
        }
    }
}
