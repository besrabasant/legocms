@php
$id = isset($id)? $id: $name;
$model = ${$module_singular};
$rows = isset($rows)? $rows: 6;
$help = $help ?? false;
$translated = isset($translated)? $translated: 
    ($model->isTranslatable([$name]))? true: false;
@endphp

@if($translated)
    <legocms-translatable-formfield
        type="legocms-form-input-textarea"
        :attributes="{
            id: '{{ $id }}',
            label: '{{ $label }}', 
            name: '{{ $name }}',
            rows: '{{$rows}}'
            @if ($help) help: '{{$help}}' @endif
        }"
        >
    </legocms-translatable-formfield>
@else
<legocms-form-input-textarea 
    id="{{$id}}"
    name="{{$name}}" 
    value="{{$value}}" 
    label="{{$label}}"
    rows="{{$rows}}"
    @if($help) help="{{$help}}" @endif
    >
</legocms-form-input-textarea>
@endif

@include('legocms::admin.form._field-values')
