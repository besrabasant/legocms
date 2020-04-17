@php
    $emptyRowColSpan = \count($listings->getColumns()) + 1;
@endphp

<tr class="listings__row listings__row--empty">
    <td class="listings__column-item" colspan="{{ $emptyRowColSpan }}">
        <div class="empty-records">
            {{ \trans("legocms::listings.empty_records") }}
        </div>
    </td>
</tr>