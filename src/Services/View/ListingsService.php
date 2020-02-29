<?php

namespace LegoCMS\Services\View;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * Class ListingsService
 *
 * @package LegoCMS\Services\View
 * @category Services
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Services/View/ListingsService.php
 */
class ListingsService extends AbstractService
{
    /**
     * Resolves FormAction based on currrent Action.
     *
     * @param  string  $action
     *
     * @return  string
     */
    public function getRowActionlabel($action)
    {
        if (Arr::has($this->attributes, "row_action_labels." . $action)) {
            return Arr::get($this->attributes, "row_action_labels." . $action);
        }

        return trans("legocms::listings.row_action_labels." . $action);
    }

    /**
     * Returns config for delete confirmation dialog.
     *
     * @return  void
     */
    public function getDeleteConfimationConfig()
    {
        return [
            'title' => trans(
                "legocms::listings.delete_confirmation.title",
                [
                    'item' => Str::title($this->getModuleNameSingular())
                ]
            ),

            'content' => trans(
                "legocms::listings.delete_confirmation.content",
                [
                    'item' => $this->getModuleNameSingular()
                ]
            ),

            'cancelBtnLabel' => trans("legocms::listings.delete_confirmation.cancel"),
            'confirmBtnLabel' => trans("legocms::listings.delete_confirmation.confirm"),
        ];
    }
}
