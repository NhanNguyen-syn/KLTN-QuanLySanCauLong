@php
    use Illuminate\Support\Arr;
    $icon = Arr::get($formOptions, 'icon');
    $heading = Arr::get($formOptions, 'heading');
    $description = Arr::get($formOptions, 'description');
    $banner = Arr::get($formOptions, 'banner');
@endphp

@push('styles')
    <style>
        .auth-outer { min-height: 70vh; }
        .auth-card-outer { border: 0; border-radius: 1rem; overflow: hidden; }
        .auth-side { background: linear-gradient(135deg, #ff4d4f, #ff6a3d); color: #fff; }
        .auth-side .brand { display: flex; align-items: center; gap: .75rem; }
        .auth-side .brand img { max-height: 56px; width: auto; }
        .auth-side .feature { opacity: .95; }
        .auth-form { background: #fff; }
        .auth-form .card-body { padding: 2rem 2rem; }
        @media (min-width: 992px) { .auth-form .card-body { padding: 3rem 3rem; } }
        .auth-form .form-control, .auth-form .form-select { border-radius: .6rem; }
        .auth-form .btn-primary { background: linear-gradient(135deg, #ff4d4f, #ff6a3d); border: 0; }
        .auth-form .btn-primary:hover { filter: brightness(0.95); }
    </style>
@endpush

@if (Arr::get($formOptions, 'has_wrapper', 'yes') === 'yes')
<div class="container auth-outer py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="row g-0 shadow-lg auth-card-outer">
                <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between auth-side p-4 p-lg-5">
                    <div class="brand">
                        @if($logo = Theme::getLogo())
                            {{ Theme::getLogoImage(maxHeight: 56) }}
                        @else
                            <h4 class="mb-0">{{ theme_option('site_title', 'Website') }}</h4>
                        @endif
                    </div>

                    <div>
                        <h3 class="fw-bold mb-2">{{ $heading ?: __('Register an account') }}</h3>
                        @if ($description)
                            <p class="feature mb-0">{{ $description }}</p>
                        @else
                            <p class="feature mb-0">{{ __('Create your account to start booking courts and manage your activities easily.') }}</p>
                        @endif
                    </div>

                    @if ($banner)
                        <div class="text-center mt-4">
                            {{ RvMedia::image($banner, $heading ?: '', attributes: ['class' => 'img-fluid rounded shadow-sm']) }}
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 auth-form bg-white">
                    <div class="card h-100 border-0 rounded-0">
                        <div class="card-body">
                            @if ($showStart)
                                {!! Form::open(Arr::except($formOptions, ['template'])) !!}
                            @endif

                            @if (session()->has('status'))
                                <div role="alert" class="alert alert-success">{{ session('status') }}</div>
                            @elseif (session()->has('auth_error_message'))
                                <div role="alert" class="alert alert-danger">{{ session('auth_error_message') }}</div>
                            @elseif (session()->has('auth_success_message'))
                                <div role="alert" class="alert alert-success">{{ session('auth_success_message') }}</div>
                            @elseif (session()->has('auth_warning_message'))
                                <div role="alert" class="alert alert-warning">{{ session('auth_warning_message') }}</div>
                            @endif

                            @if ($showFields)
                                {{ $form->getOpenWrapperFormColumns() }}
                                @foreach ($fields as $field)
                                    @continue(in_array($field->getName(), $exclude))
                                    {!! $field->render() !!}
                                @endforeach
                                {{ $form->getCloseWrapperFormColumns() }}
                            @endif

                            @if ($showEnd)
                                {!! Form::close() !!}
                            @endif

                            @if ($form->getValidatorClass())
                                @push('footer')
                                    {!! $form->renderValidatorJs() !!}
                                @endpush
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
    <div class="card bg-body-tertiary border-0">
        <div class="card-body">
            @if ($showStart)
                {!! Form::open(Arr::except($formOptions, ['template'])) !!}
            @endif

            @if ($showFields)
                {{ $form->getOpenWrapperFormColumns() }}
                @foreach ($fields as $field)
                    @continue(in_array($field->getName(), $exclude))
                    {!! $field->render() !!}
                @endforeach
                {{ $form->getCloseWrapperFormColumns() }}
            @endif

            @if ($showEnd)
                {!! Form::close() !!}
            @endif
        </div>
    </div>
@endif

