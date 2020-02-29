@php
$model = ${$module_singular};
$id = isset($id)? $id: $name;
$translated = isset($translated)? $translated: 
    ($model->isTranslatable([$name]))? true: false;
@endphp

@if($translated)
    <legocms-translatable-formfield
        type="legocms-form-input-hidden"
        :attributes="{
            id: '{{ $id }}',
            name: '{{ $name }}'
        }"
        >
    </legocms-translatable-formfield>
@else
<legocms-form-input-hidden 
    id="{{$id}}"
    name="{{$name}}" 
    >
</legocms-form-input-hidden>
@endif

@include('legocms::admin.form._field-values')