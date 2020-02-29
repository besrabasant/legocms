<nav class="legocms__global-nav global-nav">
    <ul class="global-nav__menu">
        @if($menu_items = app('legocms::services.menu')->buildGlobalMenu())
            @foreach($menu_items as $menu_item)
            @if($menu_item === 'seperator')
                <li class="global-nav__separator"></li>
            @else
                <li class="global-nav__item @if(app('legocms::services.menu')->isActiveMenu('global',$menu_item, $menu_item['key'])) global-nav__item--active @endif">
                
                @if(\array_key_exists('route', $menu_item))
                    <a class="global-nav__link" href="{{\route("legocms.".$menu_item['route'])}}">{{ __($menu_item['title']) }}</a>
                @endif
                
                @if(\array_key_exists('link', $menu_item))
                <a class="global-nav__link" href="{{url($menu_item['link'])}}">{{ __($menu_item['title']) }}</a>
                @endif
                
                </li>
            @endif
            @endforeach
        @endif
    </ul>
</nav>