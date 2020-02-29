@php
$model = ${$module_singular};
$id = isset($id)? $id: $name;
$help = $help ?? false;
$translated = isset($translated)? $translated: 
    ($model->isTranslatable([$name]))? true: false;
@endphp

@if($translated)
    <legocms-translatable-formfield
        type="legocms-form-input-select"
        :attributes="{
            id: '{{ $id }}',
            name: '{{ $name }}',
            label: '{{ $label }}',
            options: '{{ json_encode($userRoles) }}',
            default-label: '{{$defaultLabel}}',
            @if ($help) help: '{{$help}}' @endif
        }"
        >
    </legocms-translatable-formfield>
@else
<legocms-form-input-select 
    id="{{$id}}"
    name="{{$name}}" 
    label="{{$label}}"
    :options="{{ json_encode($userRoles) }}"
    default-label="{{$defaultLabel}}" 
    @if($help) help="{{$help}}" @endif
    >
</legocms-form-input-select>
@endif

@include('legocms::admin.form._field-values')
