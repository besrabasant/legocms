<?php

namespace LegoCMS\Services\View;

use Illuminate\Foundation\Application;

/**
 * Class FormService
 *
 * @package LegoCMS\Services\View
 * @category Services
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Services/View/FormService.php
 */
class FormService extends AbstractService
{
    /**
     * FormConfig.
     *
     * @var  array
     */
    private $formConfig = [];


    /**
     * {@inheritDoc}
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->setFormConfigDefaults();
    }

    /**
     * Resolves FormAction based on currrent Action.
     *
     * @param  string|null  $action
     *
     * @return  string
     */
    public function getFormAction($action = null)
    {
        $currentAction = $action ? $action : $this->getCurrentAction();

        if ($currentAction === 'create') {
            return 'store';
        }

        if ($currentAction === 'edit') {
            return 'update';
        }

        return $currentAction;
    }

    /**
     * Resolves Form Action Label
     *
     * @param  string  $action
     *
     * @return  string
     */
    public function getFormActionLabel($action = "")
    {
        $currentAction = $action ? $action : $this->getCurrentAction();

        return \trans("legocms::forms.form_action_labels." . $currentAction);
    }

    /**
     * Returns Form Config.
     *
     * @param  bool  $json_encode
     *
     * @return  array|string
     */
    public function getConfig($json_encode = true)
    {
        return $json_encode ? \json_encode($this->formConfig) : $this->formConfig;
    }

    /**
     * Sets Form Config.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return  array
     */
    public function setConfig($key, $value)
    {
        \data_set($this->formConfig, $key, $value);
    }
}
