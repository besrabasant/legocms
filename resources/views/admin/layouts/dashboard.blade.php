@extends('legocms::admin.layouts.main')

@section('headerNavigation')

@endsection

@section('content')
    @hasSection('dashboard__beforeContent')
        @yield('dashboard__beforeContent')
    @endif

    @yield('dashboard__content')

    @hasSection('dashboard__afterContent')
        @yield('dashboard__afterContent')
    @endif
@endsection