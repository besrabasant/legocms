<?php

namespace LegoCMS\Models\Contracts;

/**
 * interface Sortable.
 */
interface Sortable
{
    public function scopeOrdered($query);

    public static function setNewOrder($ids, $startOrder = 1);
}
