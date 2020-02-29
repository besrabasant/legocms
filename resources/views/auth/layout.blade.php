<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('legocms::partials.head')
    <meta name="turbolinks-cache-control" content="no-cache"/>
    <link href="{{mix('/admin/css/legocms-auth.css', 'assets')}}" rel="stylesheet" type="text/css"/>
    <script src="{{ mix('/admin/js/legocms-auth.js', 'assets') }}" type="text/javascript" defer></script>
</head>
<body>
{{ svg_spritesheet() }}
<div class="legocms legocms--auth auth">
    <div class="auth__image">
        <figure class="figure">
            <img class="figure__img" src="https://picsum.photos/1000"/>
        </figure>
    </div>
    <div class="auth__form">
        <div class="auth__form-container">
            @include("legocms::partials.logo")
            <h1 class="auth__screen-title">{{ $screenTitle }}</h1>
            
            @include("legocms::auth.errors")

            <form class="flex flex-col" action="{{ $route }}" method="POST">
                @csrf
                @yield('content')
            </form>
        </div>
        @include("legocms::partials.made-with")
    </div>
</div>
</body>
</html>
