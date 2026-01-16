<div class="form-group">
    <label for="widget-title">{{ __('Title') }}</label>
    <input type="text" class="form-control" name="title" value="{{ $config['title'] ?? '' }}">
</div>

<hr>

@for ($i = 1; $i <= 5; $i++)
    <div class="form-group">
        <label class="form-label">{{ __('Icon :number Image', ['number' => $i]) }}</label>
        {!! Form::mediaImage('icon_' . $i . '_image', $config['icon_' . $i . '_image'] ?? null) !!}
    </div>
    <div class="form-group">
        <label class="form-label">{{ __('Icon :number URL', ['number' => $i]) }}</label>
        <input type="text" class="form-control" name="icon_{{ $i }}_url" value="{{ $config['icon_' . $i . '_url'] ?? '' }}">
    </div>
    @if ($i < 5) <hr> @endif
@endfor

