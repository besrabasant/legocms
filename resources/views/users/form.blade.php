@extends('legocms::admin.layouts.form', ['defaultFields' => false])

@section('form__content')

@formField('text', [
    'name' => 'name',
    'id' => 'name',
    'label' => 'Name'
])

@formField('email', [
    'name' => 'email',
    'id' => 'email',
    'label' => 'Email'
])

@formField('select', [
    'label' => "Role",
    'name'=> "role",
    'id' => "role", 
    'options' => $userRoles, 
    'defaultLabel' => "Select a Role"
])

@endsection