@extends('legocms::auth.layout', [
    'route' => route('legocms.admin.password.reset.email'),
     'screenTitle' => trans("legocms::auth.reset_password")
])

@section('content') 
    <fieldset class="auth__fieldset">
    <label class="auth__fieldlabel" for="email">{{ trans("legocms::common.email") }} :</label>
        <input class="auth__fieldinput" type="email" name="email" id="email" required autofocus/>
    </fieldset>

    <input class="auth__btn" type="submit" value="{{ trans("legocms::auth.send_password_reset_link") }}">
@endsection