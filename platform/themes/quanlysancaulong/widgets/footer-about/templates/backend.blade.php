<div class="form-group">
    <label>{{ __('Logo') }}</label>
    {!! Form::mediaImage('logo', $config['logo'] ?? null) !!}
</div>

<div class="form-group">
    <label for="widget-headline">{{ __('Headline') }}</label>
    <input type="text" class="form-control" name="headline" value="{{ $config['headline'] ?? '' }}">
</div>

<div class="form-group">
    <label for="widget-description_text">{{ __('Description') }}</label>
    <textarea name="description_text" class="form-control" rows="4">{{ $config['description_text'] ?? '' }}</textarea>
    <small class="text-muted">{{ __('Dùng Enter để xuống dòng.') }}</small>
</div>

<div class="form-group">
    <label for="widget-phone">{{ __('Phone') }}</label>
    <input type="text" class="form-control" name="phone" value="{{ $config['phone'] ?? '' }}">
</div>
<div class="form-group">
    <label>{{ __('Phone Icon') }}</label>
    {!! Form::mediaImage('phone_icon', $config['phone_icon'] ?? null) !!}
</div>

<div class="form-group">
    <label for="widget-email">{{ __('Email') }}</label>
    <input type="email" class="form-control" name="email" value="{{ $config['email'] ?? '' }}">
</div>
<div class="form-group">
    <label>{{ __('Email Icon') }}</label>
    {!! Form::mediaImage('email_icon', $config['email_icon'] ?? null) !!}
</div>
