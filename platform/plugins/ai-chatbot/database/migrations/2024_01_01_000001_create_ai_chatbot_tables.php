<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Knowledge base items
        Schema::create('ai_knowledge_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('category', ['court', 'pricing', 'promotion', 'faq', 'general'])->default('general');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'is_active']);
            $table->fullText(['title', 'content']);
        });

        // Chat conversations
        Schema::create('ai_chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->index();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->json('messages')->nullable();
            $table->timestamps();
        });

        // Seed default FAQ data
        $this->seedDefaultKnowledge();
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_chat_conversations');
        Schema::dropIfExists('ai_knowledge_items');
    }

    protected function seedDefaultKnowledge(): void
    {
        $items = [
            [
                'title' => 'Cách đặt sân',
                'content' => 'Để đặt sân cầu lông: 1) Đăng nhập tài khoản, 2) Vào trang Đặt Sân, 3) Chọn ngày và khung giờ, 4) Chọn sân phù hợp, 5) Xác nhận và thanh toán. Có thể thanh toán qua VNPay hoặc tiền mặt.',
                'category' => 'faq',
            ],
            [
                'title' => 'Giá thuê sân',
                'content' => 'Giá thuê sân dao động từ 80.000đ - 150.000đ/giờ tùy khung giờ. Giờ cao điểm (18h-21h) có giá cao hơn. Chi tiết giá xem tại trang Đặt Sân.',
                'category' => 'pricing',
            ],
            [
                'title' => 'Ưu đãi khách hàng',
                'content' => 'Ưu đãi hiện có: Giảm 10% khi đặt sân theo tháng (cố định), Giảm 15% cho nhóm từ 4 người, Miễn phí nước uống cho khách VIP, Tích điểm đổi quà.',
                'category' => 'promotion',
            ],
            [
                'title' => 'Quy định hủy đặt',
                'content' => 'Quy định hủy: Hủy trước 24h hoàn 100%, hủy trước 12h hoàn 50%, hủy trước 6h hoàn 20%, hủy dưới 6h không hoàn tiền.',
                'category' => 'faq',
            ],
            [
                'title' => 'Giờ hoạt động',
                'content' => 'Giờ hoạt động: Thứ 2-6: 6h-22h, Thứ 7-CN: 6h-23h, Ngày lễ: 7h-22h. Giờ vàng (peak): 17h-21h.',
                'category' => 'faq',
            ],
            [
                'title' => 'Liên hệ hỗ trợ',
                'content' => 'Liên hệ: Hotline 0909.XXX.XXX, Email contact@sancaulongnienthoi.vn. Hỗ trợ 24/7 qua chatbot hoặc hotline.',
                'category' => 'faq',
            ],
        ];

        foreach ($items as $item) {
            \DB::table('ai_knowledge_items')->insert([
                ...$item,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
};
