@extends('legocms::admin.layouts.main')

@php
$model = ${$module_singular};

$pageTitle = isset($pageTitle)? $pageTitle : $page->getPageTitle();
@endphp

@section('content')
    <div class="page page--single">
        <div class="page__container">
            <div class="page__header">
                <h2 class="page__title">{{$pageTitle}}</h2>
                @hasSection('form__before-content')
                    @yield('form__before-content')
                @endif
            </div>

            <div class="page__body">
            </div>

            <div class="page__footer">
                @hasSection('form__after-content')
                    @yield('form__after-content')
                @endif
            </div>
        </div>
    </div>
@endsection