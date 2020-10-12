@if(isset($config['name']) && $config['name'] == 'My Account Top Menu')
    @foreach($menu_items as $key=>$item)
        @if($item->slug != 'logout')
        <li class="menu__item">
            <div class="menu__item-submenu-offset"></div>
            <a class="menu__item-link" href="{{$item->slug}}">{{$item->title}}</a>
        </li>
        @endif
        @if($item->slug == 'logout')
            <li class="menu__item">
                <div class="menu__item-submenu-offset"></div>
                <a class="menu__item-link" href="javascript::void(0);" onclick="event.preventDefault(); document.getElementById('logout-form-menu').submit();">{{$item->title}}</a>
                <form id="logout-form-menu" action="{{ route('logout') }}" method="POST" style="display: none;">
                                           @csrf
                                        </form>
            </li>
        @endif
    @endforeach
@else
    @foreach($menu_items as $key=>$item)
        <div class="topbar__item topbar__item--link">
            <a class="topbar-link" href="{{$item->slug}}">{{$item->title}}</a>
        </div>
    @endforeach
@endif