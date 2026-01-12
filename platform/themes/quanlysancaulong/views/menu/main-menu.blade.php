@if ($menuNodes->count())
    <ul class="{{ $options['class'] }}">
        @foreach ($menuNodes as $key => $row)
            @php
                $hasChildren = $row->has_child;
                $active = $row->url && (url($row->url) == url()->current() || (url()->current() == url('/') && $row->url == '/'));
                $activeClass = $active ? 'active' : '';
                $hasChildrenClass = $hasChildren ? 'dropdown' : '';
                $linkClass = $hasChildren ? 'dropdown-toggle' : '';
                $linkAttributes = $hasChildren ? 'role="button" data-bs-toggle="dropdown" aria-expanded="false"' : '';
            @endphp
            <li class="nav-item {{ $activeClass }} {{ $hasChildrenClass }}">
                <a 
                    class="nav-link {{ $linkClass }}" 
                    href="{{ $row->url }}" 
                    target="{{ $row->target }}"
                    {!! $linkAttributes !!}
                >
                    @if ($icon = $row->getMetadata('icon_font', true))
                        <i class="{{ $icon }}"></i>
                    @endif
                    {{ $row->title }}
                </a>
                @if ($hasChildren)
                    <ul class="dropdown-menu">
                        @foreach ($row->child as $child)
                            @php
                                $childActive = $child->url && (url($child->url) == url()->current() || (url()->current() == url('/') && $child->url == '/'));
                                $childActiveClass = $childActive ? 'active' : '';
                            @endphp
                            <li class="{{ $childActiveClass }}">
                                <a class="dropdown-item" href="{{ $child->url }}" target="{{ $child->target }}">
                                    @if ($icon = $child->getMetadata('icon_font', true))
                                        <i class="{{ $icon }}"></i>
                                    @endif
                                    {{ $child->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
@endif
