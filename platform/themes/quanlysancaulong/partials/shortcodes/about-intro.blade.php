<style>
    @keyframes lightSweep {
        0% { transform: translateX(-100%) skewX(-15deg); }
        100% { transform: translateX(200%) skewX(-15deg); }
    }
    .btn-light-sweep::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 30%;
        height: 100%;
        background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
        transform: translateX(-100%) skewX(-15deg);
        animation: lightSweep 3s infinite;
    }
    @keyframes slideInLeft {
        0% { opacity: 0; transform: translateX(-60px); }
        100% { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInRight {
        0% { opacity: 0; transform: translateX(60px); }
        100% { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideUp {
        0% { opacity: 0; transform: translateY(40px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-in-left {
        animation: slideInLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .animate-slide-in-right {
        animation: slideInRight 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .animate-slide-up {
        opacity: 0;
        animation: slideUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
<section class="py-20 overflow-hidden" style="background-color: {{ $shortcode->background_color ?? '#ffffff' }};">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6 animate-slide-in-left">
                @if($shortcode->title)
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wide"
                         style="background-color: {{ $shortcode->title_bg_color ?? 'rgba(6, 94, 69, 0.1)' }}; color: {{ $shortcode->title_color ?? '#065e45' }};">
                        {!! BaseHelper::clean($shortcode->title) !!}
                    </div>
                @endif
                
                @if($shortcode->subtitle)
                    <h2 class="text-3xl md:text-4xl font-extrabold font-serif"
                        style="color: {{ $shortcode->heading_color ?? '#153E35' }};">
                        {!! BaseHelper::clean($shortcode->subtitle) !!}
                    </h2>
                @endif

                @if($shortcode->content)
                    <p class="text-lg leading-relaxed"
                       style="color: {{ $shortcode->text_color ?? '#4b7d70' }};">
                        {!! BaseHelper::clean($shortcode->content) !!}
                    </p>
                @endif

                @if($shortcode->sub_content)
                    <p class="text-lg leading-relaxed"
                       style="color: {{ $shortcode->text_color ?? '#4b7d70' }};">
                        {!! BaseHelper::clean($shortcode->sub_content) !!}
                    </p>
                @endif

                <div class="grid grid-cols-2 gap-6 pt-4">
                    <div class="p-4 rounded-xl border border-border animate-slide-up"
                         style="background-color: {{ $shortcode->stat_bg_color ?? 'rgba(241, 245, 249, 0.3)' }}; animation-delay: 0.3s;">
                        <div class="text-3xl font-extrabold mb-1"
                             style="color: {{ $shortcode->stat_text_color ?? '#065e45' }};">{{ $shortcode->stat_1_value }}</div>
                        <div class="text-sm font-medium"
                             style="color: {{ $shortcode->stat_label_color ?? '#4b7d70' }};">{{ $shortcode->stat_1_label }}</div>
                    </div>
                    <div class="p-4 rounded-xl border border-border animate-slide-up"
                         style="background-color: {{ $shortcode->stat_bg_color ?? 'rgba(241, 245, 249, 0.3)' }}; animation-delay: 0.5s;">
                        <div class="text-3xl font-extrabold mb-1"
                             style="color: {{ $shortcode->stat_text_color ?? '#065e45' }};">{{ $shortcode->stat_2_value }}</div>
                        <div class="text-sm font-medium"
                             style="color: {{ $shortcode->stat_label_color ?? '#4b7d70' }};">{{ $shortcode->stat_2_label }}</div>
                    </div>
                </div>

                @if($shortcode->button_text)
                    <div class="pt-8 flex justify-center w-full animate-slide-up" style="animation-delay: 0.7s;">
                        <a href="{{ $shortcode->button_link ?: '#' }}" 
                           class="btn-light-sweep px-10 py-3 font-bold rounded-full relative overflow-hidden inline-flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                           style="background-color: {{ $shortcode->button_bg_color ?? '#065e45' }}; color: {{ $shortcode->button_text_color ?? '#ffffff' }};">
                            {{ $shortcode->button_text }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="animate-slide-in-right relative h-[500px] rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-secondary/20 z-10"></div>
                @if($image = $shortcode->image)
                    <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $shortcode->title }}" class="absolute inset-0 w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 bg-gray-200 flex items-center justify-center">
                        <i data-lucide="users" class="w-24 h-24 text-muted-foreground/20"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
