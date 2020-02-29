@foreach($models as $model)
<tr class="listings__row listings__row--body">

    @foreach($listings->getColumns() as $column => $label)
    @if($column === 'translations')
    <td class="listings__column-item">
        @include('legocms::admin.listings.translations', ['locales' => $model->{$column}->pluck('locale')])
    </td>
    @else
    <td class="listings__column-item">{{ $model->{$column} }}</td>
    @endif
    @endforeach
    
    <td class="listings__column-item listings__column-item--row-actions">
        <legocms-row-action-edit 
            resource-id="{{$model->id}}" 
            url="{{\moduleRoute($module, 'edit', [ $module_singular => $model->id])}}" 
            label="{{ $listings->getRowActionLabel('edit') }}" >
        </legocms-row-action-edit>
        <legocms-row-action-destroy 
            resource-id="{{$model->id}}" 
            url="{{\moduleRoute($module, 'destroy', [ $module_singular => $model->id])}}" 
            label="{{ $listings->getRowActionLabel('destroy') }}">
        </legocms-row-action-destroy>
    </td>
</tr>
@endforeach