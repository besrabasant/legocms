<?php

namespace LegoCMS\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;
use LegoCMS\Http\Requests\Contracts\ShouldValidateTranslatableAttributes;

/**
 * Class FormRequest
 *
 * @package LegoCMS\Http\Requests\Admin
 */
abstract class FormRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('legocms_users')->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->applyRules();

        if (\class_implements_interface(static::class, ShouldValidateTranslatableAttributes::class)) {
            $translateTableRules = \collect($this->applyTranslatableRules())
                ->put('active', 'required');

            if ($translateTableRules->isNotEmpty()) {
                $translateTableRules = RuleFactory::make(
                    $translateTableRules->mapWithKeys(function ($rules, $attribute) {
                        return ["%" . $attribute . "%" => $rules];
                    })->toArray()
                );

                $rules = \array_merge($rules, $translateTableRules);
            }
        }

        return $rules;
    }

    /**
     * Get the validation rules for attributes that are not translated.
     *
     * @return array
     */
    abstract public function applyRules();
}
