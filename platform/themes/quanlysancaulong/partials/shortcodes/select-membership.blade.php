@php
    $containerId = 'shortcode-select-membership-' . ($shortcode->hash ?? uniqid());
@endphp

<div id="{{ $containerId }}" data-props='@json($props)'></div>

