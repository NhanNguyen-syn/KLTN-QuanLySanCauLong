<ul {!! BaseHelper::clean($options) !!}>
    @foreach ($menu_nodes as $key => $row)
        <li @if ($row->css_class) class="{{ $row->css_class }}" @endif>
            <a href="{{ url($row->url) }}" target="{{ $row->target }}" class="text-secondary text-decoration-none transition-all hover:text-primary hover:ps-1">
                {!! $row->icon_html !!}
                <span>{{ $row->title ?: $row->name }}</span>
            </a>
            @if ($row->has_child)
                {!! Menu::generateMenu([
                    'menu'       => $menu,
                    'menu_nodes' => $row->child,
                    'view'       => 'footer-menu',
                    'options'    => ['class' => 'list-unstyled ps-3 mt-1'],
                ]) !!}
            @endif
        </li>
    @endforeach
</ul>
