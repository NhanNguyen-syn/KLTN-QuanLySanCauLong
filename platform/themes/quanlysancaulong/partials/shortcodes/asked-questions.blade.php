@php
    $containerId = 'shortcode-asked-questions-' . ($shortcode->hash ?? uniqid());
@endphp

<div id="{{ $containerId }}" data-props='@json($props)'></div>

