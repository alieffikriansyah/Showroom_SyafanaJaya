<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @if(!empty($sidebarMenus))
            @foreach($sidebarMenus as $menu)
                @if(!empty($menu->children) && count($menu->children) > 0)
                    {{-- ── MENU DENGAN SUB-MENU (COLLAPSIBLE ACCORDION) ── --}}
                    @php
                        $isGroupActive = false;
                        foreach ($menu->children as $c) {
                            if (!empty($c->route_name) && $c->route_name !== '#' && Route::has($c->route_name) && request()->routeIs($c->route_name . '*')) {
                                $isGroupActive = true;
                                break;
                            }
                        }
                    @endphp
                    <li class="nav-item {{ $isGroupActive ? 'active' : '' }}">
                        <a class="nav-link" data-toggle="collapse" href="#menu-col-{{ $menu->id_menu }}"
                           aria-expanded="{{ $isGroupActive ? 'true' : 'false' }}" aria-controls="menu-col-{{ $menu->id_menu }}">
                            <i class="{{ $menu->icon ?: 'typcn typcn-th-list' }} menu-icon"></i>
                            <span class="menu-title">{{ $menu->nama_menu }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse {{ $isGroupActive ? 'show' : '' }}" id="menu-col-{{ $menu->id_menu }}">
                            <ul class="nav flex-column sub-menu">
                                @foreach($menu->children as $child)
                                    @php
                                        $hasRoute = !empty($child->route_name) && $child->route_name !== '#' && Route::has($child->route_name);
                                        $isChildActive = $hasRoute && request()->routeIs($child->route_name . '*');
                                        $url = $hasRoute ? route($child->route_name) : (url($child->route_name ?: '#'));
                                    @endphp
                                    <li class="nav-item {{ $isChildActive ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ $url }}">
                                            @if(!empty($child->icon))
                                                <i class="{{ $child->icon }} mr-1"></i>
                                            @endif
                                            {{ $child->nama_menu }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    {{-- ── MENU TUNGGAL (DIRECT LINK) ── --}}
                    @php
                        $hasRoute = !empty($menu->route_name) && $menu->route_name !== '#' && Route::has($menu->route_name);
                        $isSingleActive = $hasRoute && request()->routeIs($menu->route_name . '*');
                        $url = $hasRoute ? route($menu->route_name) : (url($menu->route_name ?: '#'));
                    @endphp
                    <li class="nav-item {{ $isSingleActive ? 'active' : '' }}">
                        <a class="nav-link" href="{{ $url }}">
                            <i class="{{ $menu->icon ?: 'typcn typcn-device-desktop' }} menu-icon"></i>
                            <span class="menu-title">{{ $menu->nama_menu }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
</nav>
