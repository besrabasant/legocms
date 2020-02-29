<nav class="legocms__secondary-nav secondary-nav">
    <ul class="secondary-nav__menu">
        @if($menu_items = \app('legocms::services.menu')->buildSecondaryMenu())
            @foreach($menu_items as $menu_item)
            @if($menu_item === 'seperator')
                <li class="secondary-nav__separator"></li>
            @else
                <li class="secondary__item @if(app('legocms::services.menu')->isActiveMenu('secondary',$menu_item, $menu_item['key'])) secondary-nav__item--active @endif">
                
                @if(\array_key_exists('route', $menu_item))
                    <a class="secondary-nav__link" href="{{\route('legocms.'.$menu_item['route'])}}">{{ __($menu_item['title']) }}</a>
                @endif
                
                @if(\array_key_exists('link', $menu_item))
                <a class="secondary-nav__link" href="{{url($menu_item['link'])}}">{{ __($menu_item['title']) }}</a>
                @endif
                
                </li>
            @endif
            @endforeach
        @endif
    </ul>
</nav>
