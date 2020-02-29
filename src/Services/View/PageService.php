<?php

namespace LegoCMS\Services\View;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * Class PageService
 *
 * @package LegoCMS\Services\View
 * @category Services
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Services/View/PageService.php
 */
class PageService extends AbstractService
{
    /**
     * Returns Page title.
     *
     * @return  string
     */
    public function getPageTitle()
    {
        $action = $this->getCurrentAction();

        if (Arr::has($this->attributes, "page_titles.{$action}")) {
            return Arr::get($this->attributes, "page_titles.{$action}");
        }

        $title = "";

        switch ($action) {
            case 'create':
                $title =  "Create " . Str::ucfirst($this->getModuleNameSingular());
                break;
            case 'edit':
                $title =  "Edit " . Str::ucfirst($this->getModuleNameSingular());
                break;
            case 'show':
                $title =  Str::ucfirst($this->getModuleNameSingular());
                break;
            case 'index':
            default:
                $title = Str::ucfirst($this->getModuleName());
                break;
        }

        return $title;
    }

    /**
     * Return Page Action Label.
     *
     * @param [type] $action
     * @return void
     */
    public function getPageActionLabel($action = null)
    {
        $action = $action ? $action : $this->getCurrentAction();

        if (Arr::has($this->attributes, "page_action_labels.{$action}")) {
            return Arr::get($this->attributes, "page_actions_labels.{$action}");
        }

        $label = "";

        switch ($action) {
            case 'create':
                $label =  "Create " . Str::ucfirst($this->getModuleNameSingular());
                break;
            case 'edit':
                $label =  "Edit " . Str::ucfirst($this->getModuleNameSingular());
                break;
            default:
                break;
        }

        return $label;
    }
}
