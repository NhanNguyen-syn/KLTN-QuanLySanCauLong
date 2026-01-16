<section class="py-20" style="background-color: {{ $shortcode->background_color ?: 'rgba(241, 245, 249, 0.3)' }};">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 space-y-4">
            @if($shortcode->title)
                <h2 class="text-3xl md:text-4xl font-extrabold text-foreground font-serif">
                    {!! BaseHelper::clean($shortcode->title) !!}
                </h2>
            @endif
            
            @if($shortcode->subtitle)
                <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
                    {!! BaseHelper::clean($shortcode->subtitle) !!}
                </p>
            @endif
        </div>

        @if(!empty($values))
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($values as $index => $value)
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-border hover:shadow-md transition-all">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6 overflow-hidden" 
                             style="background-color: {{ $value['icon_bg'] ?? '#e0f2fe' }}">
                            @if(isset($value['icon']) && $value['icon'])
                                <img src="{{ $value['icon'] }}" alt="{{ $value['title'] ?? '' }}" class="w-8 h-8 object-contain">
                            @endif
                        </div>
                        @if(isset($value['title']))
                            <h3 class="text-xl font-bold text-foreground mb-3">{!! BaseHelper::clean($value['title']) !!}</h3>
                        @endif
                        @if(isset($value['description']))
                            <p class="text-muted-foreground leading-relaxed">
                                {!! BaseHelper::clean($value['description']) !!}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
