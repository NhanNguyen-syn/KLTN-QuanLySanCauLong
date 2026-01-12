@if (!empty($menu) && $menu->id)
    <div class="core-menu-structure">
        <input
            type="hidden"
            name="deleted_nodes"
        >
        <textarea
            name="menu_nodes"
            id="nestable-output"
            class="d-none"
        ></textarea>

        <div class="row row-cards">
            <div class="col-md-4">
                @php
                    do_action(MENU_ACTION_SIDEBAR_OPTIONS);
                @endphp

                @if (in_array('main-menu', $locations))
                    <x-core::card>
                        <x-core::card.header>
                            <a
                                class="d-flex justify-content-between w-100 align-items-center text-decoration-none"
                                data-bs-toggle="collapse"
                                data-parent="#accordion"
                                href="#collapseSpecialLink"
                            >
                                <x-core::card.title>
                                    Special Items
                                </x-core::card.title>

                                <button
                                    type="button"
                                    class="btn-action"
                                >
                                    <x-core::icon name="ti ti-chevron-down" size="sm" />
                                </button>
                            </a>
                        </x-core::card.header>
                        <div
                            id="collapseSpecialLink"
                            class="box-links-for-menu collapse"
                        >
                            <x-core::card.body>
                                <div class="the-box">
                                    <div class="node-content" id="special-items-box">
                                        <div class="d-grid gap-2">
                                            <x-core::button
                                                type="button"
                                                class="btn-add-special"
                                                :data-url="route('menus.get-node')"
                                                icon="ti ti-plus"
                                                data-special="phone"
                                            >
                                                Add Phone
                                            </x-core::button>

                                            <x-core::button
                                                type="button"
                                                class="btn-add-special"
                                                :data-url="route('menus.get-node')"
                                                icon="ti ti-plus"
                                                data-special="lookup"
                                            >
                                                Add Tra cứu
                                            </x-core::button>
                                        </div>
                                    </div>
                                </div>
                            </x-core::card.body>

                            <script>
                                // No new JS file: reuse existing .btn-add-to-menu handler by populating #menu-node-create-form.
                                document.addEventListener('click', function (e) {
                                    const btn = e.target.closest('#special-items-box .btn-add-special[data-special]');
                                    if (!btn) {
                                        return;
                                    }

                                    const special = btn.getAttribute('data-special');

                                    // We don't keep inputs here anymore; user can edit after the item is added.
                                    // Just add with sensible defaults.
                                    const payload = {
                                        menu_id: '{{ $menu->id }}',
                                        title: '',
                                        url: '#',
                                        css_class: '',
                                        icon_font: '',
                                        phone: '',
                                        icon_link: '',
                                    };

                                    if (special === 'phone') {
                                        payload.title = 'Phone';
                                        payload.css_class = 'special-phone';
                                        payload.icon_font = 'ti ti-phone';
                                        payload.phone = '0886 264 644';
                                        payload.icon_link = 'tel:0886264644';
                                    }

                                    if (special === 'lookup') {
                                        payload.title = 'Tra cứu';
                                        payload.url = '/tra-cuu';
                                        payload.css_class = 'special-lookup';
                                        payload.icon_font = 'ti ti-file-search';
                                        payload.icon_link = '/tra-cuu';
                                    }

                                    const url = btn.getAttribute('data-url');

                                    // Call the same endpoint as core JS: menus.get-node
                                    const params = new URLSearchParams();
                                    Object.keys(payload).forEach((key) => {
                                        params.append('data[' + key + ']', payload[key]);
                                    });

                                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                                    fetch(url + '?' + params.toString(), {
                                        method: 'GET',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'X-CSRF-TOKEN': token || '',
                                        },
                                    })
                                        .then((r) => r.json())
                                        .then((res) => {
                                            const html = res?.data?.html;
                                            if (!html) {
                                                return;
                                            }

                                            const wrap = document.createElement('div');
                                            wrap.innerHTML = html;
                                            const node = wrap.firstElementChild;
                                            if (!node) {
                                                return;
                                            }

                                            const list = document.querySelector('.nestable-menu > ol.dd-list');
                                            list?.appendChild(node);

                                            // Re-init media/resources if available
                                            if (window.Botble?.initResources) {
                                                window.Botble.initResources();
                                            }
                                            if (window.Botble?.initMediaIntegrate) {
                                                window.Botble.initMediaIntegrate();
                                            }
                                        });
                                });
                            </script>
                        </div>
                    </x-core::card>
                @endif

                <x-core::card>
                    <x-core::card.header>
                        <a
                            class="d-flex justify-content-between w-100 align-items-center text-decoration-none"
                            data-bs-toggle="collapse"
                            data-parent="#accordion"
                            href="#collapseCustomLink"
                        >
                            <x-core::card.title>
                                {{ trans('packages/menu::menu.add_link') }}
                            </x-core::card.title>

                            <button
                                type="button"
                                class="btn-action"
                            >
                                <x-core::icon name="ti ti-chevron-down" size="sm" />
                            </button>
                        </a>
                    </x-core::card.header>
                    <div
                        id="collapseCustomLink"
                        class="box-links-for-menu collapse"
                    >
                        <x-core::card.body>
                            <div
                                id="external_link"
                                class="the-box"
                            >
                                <div
                                    class="node-content"
                                    id="menu-node-create-form"
                                >
                                    {!! Botble\Menu\Forms\MenuNodeForm::create()->renderForm([], false, true, false) !!}
                                </div>
                            </div>
                        </x-core::card.body>
                        <x-core::card.footer class="text-end">
                            <x-core::button
                                type="button"
                                class="btn-add-to-menu"
                                :data-url="route('menus.get-node')"
                                icon="ti ti-plus"
                            >
                                {{ trans('packages/menu::menu.add_to_menu') }}
                            </x-core::button>
                        </x-core::card.footer>
                    </div>
                </x-core::card>
            </div>
            <div class="col-md-8">
                <x-core::card class="mb-3">
                    <x-core::card.header>
                        <x-core::card.title>{{ trans('packages/menu::menu.structure') }}</x-core::card.title>
                    </x-core::card.header>
                    <x-core::card.body>
                        <x-core::alert type="info" class="bg-white text-info">
                            {{ trans('packages/menu::menu.drag_drop_info') }}
                        </x-core::alert>

                        <div
                            class="dd nestable-menu"
                            id="nestable"
                            data-depth="0"
                        >
                            {!! Menu::generateMenu([
                                'slug' => $menu->slug,
                                'view' => 'packages/menu::partials.menu',
                                'theme' => false,
                                'active' => false,
                            ]) !!}
                        </div>
                    </x-core::card.body>
                </x-core::card>

                @if (defined('THEME_MODULE_SCREEN_NAME'))
                    <x-core::card>
                        <x-core::card.header>
                            <x-core::card.title>{{ trans('packages/menu::menu.menu_settings') }}</x-core::card.title>
                        </x-core::card.header>
                        <x-core::card.body>
                            <div class="row">
                                <div class="col-md-4">
                                    <p><i>{{ trans('packages/menu::menu.display_location') }}</i></p>
                                </div>
                                <div class="col-md-8">
                                    @foreach (Menu::getMenuLocations() as $location => $description)
                                        <div @class(['mb-3' => ! $loop->last])>
                                            <x-core::form.checkbox
                                                :label="$description"
                                                id="menu_location_{{ $location }}"
                                                name="locations[]"
                                                :checked="in_array($location, $locations)"
                                                :value="$location"
                                            />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </x-core::card.body>
                    </x-core::card>
                @endif
            </div>
        </div>
    </div>
@endif
