@php
$model = ${$module_singular};
if($model->isTranslatable([$name])) {
    $value = [];
    foreach(\getLocales() as $locale) {
        $value[$locale] = \old("{$locale}.{$name}", \optional($model->translate($locale))->{$name});
    }
} else {
    $value = \old($name, $model->{$name});
}

$forms->setConfig('fieldValues.'.$name, ($value ?? ""));    
@endphp