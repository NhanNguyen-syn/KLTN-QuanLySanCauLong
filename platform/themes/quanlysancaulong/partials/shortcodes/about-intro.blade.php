<section class="py-20" style="background-color: {{ $shortcode->background_color ?? '#ffffff' }};">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
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
                    <div class="p-4 rounded-xl border border-border"
                         style="background-color: {{ $shortcode->stat_bg_color ?? 'rgba(241, 245, 249, 0.3)' }};">
                        <div class="text-3xl font-extrabold mb-1"
                             style="color: {{ $shortcode->stat_text_color ?? '#065e45' }};">{{ $shortcode->stat_1_value }}</div>
                        <div class="text-sm font-medium"
                             style="color: {{ $shortcode->stat_label_color ?? '#4b7d70' }};">{{ $shortcode->stat_1_label }}</div>
                    </div>
                    <div class="p-4 rounded-xl border border-border"
                         style="background-color: {{ $shortcode->stat_bg_color ?? 'rgba(241, 245, 249, 0.3)' }};">
                        <div class="text-3xl font-extrabold mb-1"
                             style="color: {{ $shortcode->stat_text_color ?? '#065e45' }};">{{ $shortcode->stat_2_value }}</div>
                        <div class="text-sm font-medium"
                             style="color: {{ $shortcode->stat_label_color ?? '#4b7d70' }};">{{ $shortcode->stat_2_label }}</div>
                    </div>
                </div>
            </div>

            <div class="relative h-[500px] rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
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
