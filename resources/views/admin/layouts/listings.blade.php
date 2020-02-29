@extends('legocms::admin.layouts.main')

@php
$pageTitle = isset($pageTitle)? $pageTitle : $page->getPageTitle();

$models = ${$module};

$listingsConfig = [
    'modals' => [
        'delete_confirmation' => $listings->getDeleteConfimationConfig(),
    ],
];

@endphp

@push('admin__footer--js')
<script type="text/javascript">window.{{ \config('legocms.js_namespace') }}.LISTINGS = @php echo json_encode($listingsConfig); @endphp</script>
@endpush

@section('content')
    <div class="page page--listings" id="listings-root">
        <div class="page__container">
            <div class="page__header">
                <h2 class="page__title">{{$pageTitle}}</h2>
                <div class="page__actions">
                    <legocms-resource-action-create url="{{\moduleRoute($module, 'create')}}" label="{{ $page->getPageActionLabel('create') }}" />
                </div>
                @hasSection('listings__before-content')
                    @yield('listings__before-content')
                @endif
            </div>

            <div class="page__body">
                <table class="listings" id="listings">
                    <thead class="listings__header">
                    <tr class="listings__row listings__row--head">
                        @foreach($listings->getColumns() as $label)
                        <td class="listings__column-item">{{ $label }}</td>
                        @endforeach

                        @yield('listings__content-header')
                        
                        @unless(empty($listings->getColumns()))
                        <td class="listings__column-item listings__column-item--row-actions">Actions</td>
                        @endif
                    </tr>
                    </thead>

                    <tbody class="listings__body">
                        @unless($models->isEmpty())
                            @include("legocms::partials.listings.rows")
                            @yield('listings__content')
                        @else
                            @include("legocms::partials.listings.empty")
                        @endif
                    </tbody>

                </table>
            </div>

            <div class="page__footer">
                @hasSection('listings__after-content')
                    @yield('listings__after-content')
                @endif
            </div>

        </div>
        <legocms-delete-confirm />
    </div>
@endsection