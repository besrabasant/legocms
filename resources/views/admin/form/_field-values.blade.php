@php
$model = ${$module_singular};
if($model->isTranslatable([$name])) {
    $value = [];
    foreach(\getLocales() as $locale) {
        $value[$locale] = \optional($model->translate($locale))->{$name};
    }
} else {
    $value = $model->{$name};
}
$forms->setConfig('fieldValues.'.$name, $value);    
@endphp