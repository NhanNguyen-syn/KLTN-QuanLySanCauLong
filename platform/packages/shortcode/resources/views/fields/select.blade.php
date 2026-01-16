@php
    $selectedValues = $multiple ? (array) $value : [$value];
@endphp
<select
    class="select-full"
    name="{{ $field }}"
    @if ($multiple) multiple @endif
>
    @foreach ($options as $key => $label)
        <option
            value="{{ $key }}"
            @selected(in_array($key, $selectedValues, true))
        >{{ $label }}</option>
    @endforeach
</select>
