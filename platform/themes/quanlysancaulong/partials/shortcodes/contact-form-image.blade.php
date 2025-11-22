@php
    $containerId = 'shortcode-contact-form-image-' . $shortcode->hash;

    $imageUrl = null;
    if (!empty($shortcode->image)) {
        $imageUrl = RvMedia::getImageUrl($shortcode->image);
    } elseif (!empty($shortcode->image_url)) {
        $imageUrl = $shortcode->image_url;
    }

    $props = [
        'title' => $shortcode->title ?: __('Hãy liên hệ với chúng tôi'),
        'subtitle' => $shortcode->subtitle ?: '',
        'titleColor' => $shortcode->title_color ?: '#1a1a1a',
        'labelName' => $shortcode->label_name ?: __('Họ và Tên'),
        'labelPhone' => $shortcode->label_phone ?: __('Số điện thoại'),
        'labelEmail' => $shortcode->label_email ?: __('Email'),
        'labelSubject' => $shortcode->label_subject ?: __('Chủ đề (tùy chọn)'),
        'labelMessage' => $shortcode->label_message ?: __('Tin nhắn'),
        'buttonText' => $shortcode->button_text ?: __('GỬI TIN NHẮN'),
        'buttonColor' => $shortcode->button_color ?: '#0E6B5C',
        'buttonTextColor' => $shortcode->button_text_color ?: '#ffffff',
        'successMessage' => $shortcode->success_message ?: __('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm.'),
        'errorMessage' => $shortcode->failure_message ?: ($shortcode->error_message ?: __('Có lỗi xảy ra. Vui lòng thử lại.')),
        'contactFormUrl' => route('public.send.contact'),
        'hasRecaptcha' => (bool) ($shortcode->enable_recaptcha ?? false),
        'enableHoneypot' => (bool) ($shortcode->enable_honeypot ?? true),
    ];

    $imagePosition = in_array($shortcode->image_position, ['left','right']) ? $shortcode->image_position : 'left';
    $background = in_array($shortcode->background, ['light','none']) ? $shortcode->background : 'light';
    $imageAlt = $shortcode->image_alt ?: ($shortcode->title ?: '');
@endphp

<section class="cf-image-section cf-bg-{{ $background }}">
  <div class="cf-image-container">
    <div class="cf-card {{ $imagePosition === 'right' ? 'cf-reverse' : '' }}">
      @if ($imageUrl)
        <figure class="cf-figure">
          <img src="{{ $imageUrl }}"
               alt="{{ e($imageAlt) }}"
               loading="lazy"
               decoding="async"
               sizes="(min-width: 992px) 40vw, 100vw"
               srcset="{{ $imageUrl }} 1024w" />
        </figure>
      @endif

      <div class="cf-form-wrap">
        <div id="{{ $containerId }}" data-props='@json($props)'></div>
      </div>
    </div>
  </div>
</section>

