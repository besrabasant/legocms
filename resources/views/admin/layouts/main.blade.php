<!DOCTYPE html>
<html lang="{{ \str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('legocms::partials.head')
        <link href="{{mix('/admin/css/legocms-admin.css', 'assets')}}" rel="stylesheet" type="text/css"/>
        <script src="{{ mix('/admin/js/legocms-admin.js', 'assets') }}" type="text/javascript" defer></script>
    </head>
    <body class="app-env--{{app()->environment()}}">
        {{ \svg_spritesheet() }}
        <div class="legocms legocms--admin ">
            <header class="legocms__header header">
                @include('legocms::partials.header')
            </header>

            <aside class="legocms__sidebar">
                @include('legocms::partials.navigation.global-nav')
                @include('legocms::partials.navigation.secondary-nav')
            </aside>

            <main class="legocms__main main">
                @yield('content')
            </main>

            <footer class="legocms__footer footer">
                @include('legocms::partials.footer')
            </footer>
        </div>

        @include("legocms::admin.app-config")

        @stack("admin__footer--js")
    </body>
</html>
