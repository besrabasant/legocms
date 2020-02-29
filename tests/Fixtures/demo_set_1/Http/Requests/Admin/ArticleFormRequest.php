<?php

namespace DemoSet1\Http\Requests\Admin;

use LegoCMS\Http\Requests\Admin\FormRequest;
use LegoCMS\Http\Requests\Contracts\ShouldValidateTranslatableAttributes;

class ArticleFormRequest extends FormRequest implements ShouldValidateTranslatableAttributes
{
    public function applyRules()
    {
        return [
            'author' => 'required',
            'email' => 'required'
        ];
    }

    public function applyTranslatableRules()
    {
        return [
            'name' => 'required'
        ];
    }
}
