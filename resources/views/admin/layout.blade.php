<!DOCTYPE html>
<html lang="en">

<head>
    @php
    $title = \config('app.name');
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$title}}</title>

    <!-- Fonts -->
    <link rel="preload" href="{{asset(\config('legocms.public_directory') . '/fonts/Ubuntu-Light.woff')}}" as="font" type="font/woff" crossorigin />
    <link rel="preload" href="{{asset(\config('legocms.public_directory') . '/fonts/Ubuntu-Light.woff2')}}" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="{{asset(\config('legocms.public_directory') . '/fonts/Ubuntu-Regular.woff')}}" as="font" type="font/woff" crossorigin />
    <link rel="preload" href="{{asset(\config('legocms.public_directory') . '/fonts/Ubuntu-Regular.woff2')}}" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="{{asset(\config('legocms.public_directory') . '/fonts/Ubuntu-Medium.woff')}}" as="font" type="font/woff" crossorigin />
    <link rel="preload" href="{{asset(\config('legocms.public_directory') . '/fonts/Ubuntu-Medium.woff2')}}" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="{{asset(\config('legocms.public_directory') . '/fonts/Ubuntu-Bold.woff')}}" as="font" type="font/woff" crossorigin />
    <link rel="preload" href="{{asset(\config('legocms.public_directory') . '/fonts/Ubuntu-Bold.woff2')}}" as="font" type="font/woff2" crossorigin />
    
    <!-- Styles -->
    @stack('admin__head--css')

    <!-- Scripts -->
    @if(\config('debugbar.enabled'))
    <script src="{{asset(\config('legocms.public_directory') . '/js/jquery.js')}}" type="text/javascript" defer></script>
    @endif

    <script type="text/javascript">
        window.{{ \config('legocms.js_namespace') }} = {};
    </script>
    <link rel="stylesheet" href="{{ mix('/admin/css/legocms-admin-2.css', 'assets') }}" />
    <script src="{{ mix('/admin/js/legocms-admin-2.js', 'assets') }}" type="text/javascript" defer></script>
    @stack('admin__head--js')
</head>

<body class="app-env--{{app()->environment()}}">
    {{ \LegoCMS\Support\SvgSpritesheet::include('public/assets/admin/icons/sprite-common.svg') }}
    {{ \LegoCMS\Support\SvgSpritesheet::include('public/assets/admin/icons/sprite-listings.svg') }}
    <div id="__LEGOCMS__">
        {!! $content !!}
    </div>
</body>

</html>