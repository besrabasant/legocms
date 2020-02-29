@php
/**
 * @param $currentUser \LegoCMS\Models\User;
 *
 */
@endphp
@include("legocms::partials.logo")
<nav class="header__nav header-nav">
    <a class="header-nav__item">{{trans('legocms::admin.media_library')}}</a>
    @hasSection('headerNavigation')
        @yield('headerNavigation')
    @endif
</nav>

<div class="header__search global-search">
    <input type="text" class="global-search__input transition" >
</div>

<div class="header__quick-actions">

</div>

<div class="header__user-profile user-profile">
    <div class="user-profile__name">
        {{ trans('legocms::admin.welcome')  }}, <span>{{$currentUser->name}}</span>
    </div>
    <a class="user-profile__logout" href="javascript:void(0);"
       onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{trans('Logout')}}</a>
    <form action="{{route('legocms.admin.logout')}}" method="POST" id="logout-form" style="display: none;">
        @csrf
    </form>
</div>