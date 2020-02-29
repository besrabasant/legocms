@extends('legocms::auth.layout', [
    'route' => route('legocms.admin.login'),
    'screenTitle' => trans('legocms::auth.login')
])

@section('content')
    <fieldset class="auth__fieldset">
        <label for="email" class="auth__fieldlabel">{{ trans('legocms::common.email') }} :</label>
        <input type="text" class="auth__fieldinput" name="email" id="email" required autofocus tabindex="1"/>
    </fieldset>

    <fieldset class="auth__fieldset">
        <label for="password" class="auth__fieldlabel">{{ trans('legocms::common.password') }} :</label>
        <a class="auth__fieldhelp" href="{{ route('legocms.admin.password.reset.link') }}" tabindex="5"><span>{{ trans('legocms::auth.forgot_password')  }}</span></a>
        <input class="auth__fieldinput" type="password" name="password" id="password" required tabindex="2"/>
    </fieldset>

    <input class="auth__btn" type="submit" id="loginBtn" value="{{ trans('legocms::auth.login') }}" tabindex="3">

@endsection