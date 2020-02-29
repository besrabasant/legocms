@php
$model = ${$module_singular};
$id = isset($id)? $id: $name;
$help = $help ?? false;
$translated = isset($translated)? $translated: 
    ($model->isTranslatable([$name]))? true: false;
@endphp

@if($translated)
    <legocms-translatable-formfield
        type="legocms-form-input-email"
        :attributes="{
            id: '{{ $id }}',
            label: '{{ $label }}', 
            name: '{{ $name }}',
            @if ($help) help: '{{$help}}' @endif
        }"
        >
    </legocms-translatable-formfield>
@else
<legocms-form-input-email 
    id="{{$id}}"
    name="{{$name}}" 
    label="{{$label}}"
    @if($help) help="{{$help}}" @endif
    >
</legocms-form-input-email>
@endif

@include('legocms::admin.form._field-values')