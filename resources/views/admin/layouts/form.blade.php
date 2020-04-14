@extends('legocms::admin.layouts.main')

@php
$defaultFields = isset($defaultFields)? $defaultFields: true;
$model = ${$module_singular};
$pageTitle = isset($pageTitle)? $pageTitle : $page->getPageTitle();

$action = isset($action)? $action: 
        ($forms->getCurrentAction() === 'edit')? \moduleRoute($module, $forms->getFormAction(), [$module_singular => $model->id]) : 
            \moduleRoute($module, $forms->getFormAction());

if($forms->getCurrentAction() === 'edit' && !isset($method)) {
    $method = 'PUT';
}

if($errors->any()) {
    $forms->setConfig('errors', $errors->messages());
}

$forms->setConfig('translations', \getLanguagesForVueStore($model->toArray(), $model->isTranslatable()));

$forms->setConfig('revisions', $model->isRevisionable() ? $model->revisionsArray(): false);
@endphp

@section('content')
    <div class="page page--form" id="form">
        <div class="page__container">
            <div class="page__header">
                <h2 class="page__title">{{$pageTitle}}</h2>
                @hasSection('form__before-content')
                    @yield('form__before-content')
                @endif
            </div>

            <div class="page__body">
                <legocms-form 
                    action="{{$action}}"
                    @if($model->isTranslatable()) 
                    :handles-translations="true"
                    @endif
                    >

                    <legocms-form-input-hidden name="_token"> </legocms-form-input-hidden>
                    @php $forms->setConfig('fieldValues._token', \csrf_token());  @endphp

                    @isset($method)
                    <legocms-form-input-hidden name="_method"> </legocms-form-input-hidden>
                    @php $forms->setConfig('fieldValues._method', $method);  @endphp
                    @endisset

                    <div class="form__fields-container">
    
                        @if($defaultFields)
                        @hasSection('form__default-fields')
                        @yield('form__default-fields')
                        @else
                        @formField('text', [
                            'name' => 'name',
                            'label' => 'Name'
                            ])
                        @endif
                        @endif
                        
                        @yield('form__content')
                    </div>

                    <div class="form__actions-container">
                        @if($model->isTranslatable())
                        <legocms-form-translation-status></legocms-form-translation-status>
                        @endif

                        @if($model->isRevisionable())
                            <legocms-revisions></legocms-revisions>
                        @endif

                        <div class="form__actions">
                            <a class="form__btn form__btn--secondary" href="{{\moduleRoute($module)}}">
                                {{ $forms->getFormActionLabel('cancel') }}
                            </a>
                            <legocms-form-submit label="{{ $forms->getFormActionLabel() }}"></legocms-form-submit>
                            
                            @yield('form__actions')
                        </div>
                    </div>
                </legocms-form>
            </div>

            <div class="page__footer">
                @hasSection('form__after-content')
                    @yield('form__after-content')
                @endif
            </div>
        </div>
    </div>
@endsection

@push('admin__footer--js')
<script type="text/javascript">window.{{ \config('legocms.js_namespace') }}.FORMS = @php echo $forms->getConfig(); @endphp</script>
@endpush