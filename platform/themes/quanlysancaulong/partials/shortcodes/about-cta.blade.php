<section class="py-20" style="background-color: {{ $shortcode->background_color ?? '#ffffff' }};">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
        @if($shortcode->title)
            <h2 class="text-3xl md:text-4xl font-extrabold text-foreground font-serif">
                {!! BaseHelper::clean($shortcode->title) !!}
            </h2>
        @endif
        
        @if($shortcode->subtitle)
            <p class="text-lg text-muted-foreground">
                {!! BaseHelper::clean($shortcode->subtitle) !!}
            </p>
        @endif

        @if($shortcode->button_text && $shortcode->button_url)
            <div class="flex justify-center gap-4">
                <a href="{{ $shortcode->button_url }}" 
                   class="inline-flex items-center justify-center px-8 py-3 rounded-full font-bold transition-all hover:opacity-90"
                   style="background-color: {{ $shortcode->button_bg_color ?? '#065e45' }}; color: {{ $shortcode->button_text_color ?? '#ffffff' }};">
                    {!! BaseHelper::clean($shortcode->button_text) !!}
                </a>
            </div>
        @endif
    </div>
</section>
