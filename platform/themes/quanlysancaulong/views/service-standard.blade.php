{!! dynamic_sidebar('top_sidebar') !!}
@php
    $page = $page ?? null;
@endphp
@if(!empty($page))
    @php
        $pageContent = do_shortcode($page->content ?? "");
    @endphp
    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $pageContent, $page) !!}
@endif

@php
    $casualBenefits = [
        ['title' => 'Nước Uống Miễn Phí', 'description' => 'Nước uống phục vụ trong buổi chơi', 'icon' => 'droplets'],
        ['title' => 'Khăn Lau Mặt', 'description' => 'Khăn sạch hỗ trợ trong giờ chơi', 'icon' => 'shirt'],
        ['title' => 'Đặt Sân Nhanh', 'description' => 'Đặt sân dễ dàng qua hệ thống online', 'icon' => 'zap'],
        ['title' => 'Phù Hợp Trận Đấu Ngắn', 'description' => 'Thích hợp cho các trận đấu dưới 2 giờ', 'icon' => 'timer'],
    ];

    $fixedBenefits = [
        ['title' => 'Nước Uống Không Giới Hạn', 'description' => 'Phục vụ nước uống trong suốt buổi chơi', 'icon' => 'droplets', 'highlight' => true],
        ['title' => 'Khăn Cao Cấp', 'description' => 'Khăn lau khô chất lượng tốt', 'icon' => 'shirt', 'highlight' => false],
        ['title' => 'Phù Hợp Nhóm 4–6 Người', 'description' => 'Không gian phù hợp cho nhóm chơi lâu', 'icon' => 'users', 'highlight' => true],
        ['title' => 'Ưu Tiên Khung Giờ Đẹp', 'description' => 'Dễ đặt sân trong giờ cao điểm', 'icon' => 'clock', 'highlight' => false],
        ['title' => 'Tiết Kiệm Chi Phí', 'description' => 'Giảm 20.000đ mỗi giờ so với chơi nhanh', 'icon' => 'dollar-sign', 'highlight' => true],
        ['title' => 'Khu Nghỉ Cho Đội', 'description' => 'Không gian nghỉ giữa các hiệp', 'icon' => 'coffee', 'highlight' => false],
        ['title' => 'Hỗ Trợ Tổ Chức Giao Lưu', 'description' => 'Phù hợp luyện tập hoặc thi đấu nhóm', 'icon' => 'award', 'highlight' => true],
        ['title' => 'Setup Sân Nhanh', 'description' => 'Chuẩn bị sân sẵn sàng cho buổi chơi dài', 'icon' => 'check-circle', 'highlight' => true],
    ];
@endphp

<style>
    .service-standard-page section {
        background-color: #f7faf5 !important;
    }
    .service-standard-page .text-muted-foreground,
    .service-standard-page .text-sm.text-muted-foreground {
        color: #4b7d70 !important;
    }
</style>

<div class="min-h-screen flex flex-col bg-background">
    <main class="flex-1 service-standard-page">
        <section class="py-12 md:py-14 bg-background">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-16">
                    <div class="mb-10 text-center">
                        <div class="inline-block mb-4 px-4 py-1.5 rounded-full bg-[#059669]/10 border border-[#059669]/30">
                            <span class="text-sm font-bold text-[#059669]">Linh Hoạt & Tiện Lợi</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-extrabold font-serif text-foreground mb-3 text-balance">
                            Chơi Nhanh
                        </h2>
                        <p class="text-base md:text-lg text-muted-foreground text-pretty">
                            
                  Đặt sân linh hoạt với giá <span class="font-bold text-foreground">140.000đ / giờ</span>
                
                        </p>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($casualBenefits as $benefit)
                            <div class="group bg-white rounded-xl border border-border p-6 hover:shadow-lg hover:border-[#059669] transition-all duration-300 hover:-translate-y-1">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#059669] to-[#14b8a6] text-white flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-sm">
                                    <i data-lucide="{{ $benefit['icon'] }}" class="w-7 h-7"></i>
                                </div>
                                <h3 class="text-lg font-bold text-foreground mb-2">{{ $benefit['title'] }}</h3>
                                <p class="text-sm text-muted-foreground leading-relaxed">{{ $benefit['description'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="my-12 flex items-center gap-4">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-border to-border"></div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#059669] to-[#14b8a6] flex items-center justify-center shadow-sm">
                        <span class="text-lg font-bold text-white">VS</span>
                    </div>
                    <div class="flex-1 h-px bg-gradient-to-l from-transparent via-border to-border"></div>
                </div>

                <div>
                    <div class="mb-10 text-center bg-gradient-to-br from-[#065f46]/5 to-[#059669]/5 rounded-2xl border border-[#065f46]/20 p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-[#065f46]/10 to-[#059669]/10 rounded-full blur-3xl"></div>
                        <div class="relative">
                            <div class="inline-block mb-4 px-4 py-1.5 rounded-full bg-[#065f46]/20 border border-[#065f46]/30">
                                <span class="text-sm font-bold text-[#065f46]">Tiết Kiệm & Trải Nghiệm Tốt Hơn</span>
                            </div>
                            <h2 class="text-3xl md:text-4xl font-extrabold font-serif text-foreground mb-3 text-balance">
                                Chơi Dài Giờ
                            </h2>
                            <p class="text-base md:text-lg text-muted-foreground text-pretty">
                                
                    Giá ưu đãi <span class="font-bold text-[#065f46]">120.000đ / giờ</span> khi đặt từ 2 giờ trở lên
                  
                            </p>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($fixedBenefits as $benefit)
                            <div class="group relative bg-white rounded-xl border p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 {{ ($benefit['highlight'] ?? false) ? 'border-[#065f46]/40 hover:border-[#065f46]' : 'border-border hover:border-[#065f46]/30' }}">
                                @if(($benefit['highlight'] ?? false))
                                    <div class="absolute -top-2 -right-2 w-7 h-7 rounded-full bg-gradient-to-br from-[#065f46] to-[#059669] flex items-center justify-center shadow-md">
                                        <i data-lucide="award" class="w-4 h-4 text-white"></i>
                                    </div>
                                @endif
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm {{ ($benefit['highlight'] ?? false) ? 'bg-gradient-to-br from-[#065f46] to-[#059669] text-white' : 'bg-muted text-muted-foreground' }}">
                                    <i data-lucide="{{ $benefit['icon'] }}" class="w-6 h-6"></i>
                                </div>
                                <h3 class="text-base font-bold text-foreground mb-2">{{ $benefit['title'] }}</h3>
                                <p class="text-sm text-muted-foreground leading-relaxed">{{ $benefit['description'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
