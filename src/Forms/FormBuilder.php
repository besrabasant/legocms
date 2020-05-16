<?php

namespace LegoCMS\Forms;

use LegoCMS\Core\ViewBuilder;
use LegoCMS\Forms\FormFields;

class FormBuilder extends ViewBuilder
{
    protected $form;

    protected $action;

    public function forAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function getFormName(): string
    {
        return $this->module->getModuleName() . "-" . $this->action->name();
    }

    public function build(): void
    {
        $this->form = Form::make(
            $this->getFormName(),
            $this->module
        );

        $this->form
            ->setAction($this->action)
            ->setFormFields(
                new FormFields(
                    $this->module->fields($this->app['request'])
                )
            );
    }

    public function form(): Form
    {
        return $this->form;
    }
}
