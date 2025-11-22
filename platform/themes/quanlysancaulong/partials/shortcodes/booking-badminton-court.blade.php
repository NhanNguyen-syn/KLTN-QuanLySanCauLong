@php
    $containerId = 'shortcode-booking-badminton-court-' . ($shortcode->hash ?? uniqid());
@endphp

<div id="{{ $containerId }}" data-props='@json($props)'></div>

