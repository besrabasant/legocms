@if($errors->any())
<ul class="auth__errors">
@foreach ($errors->all() as $error)
    <li class="auth__error">{{ $error }}</li>
@endforeach
</ul>
@endif