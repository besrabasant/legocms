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
            $this->mergeTranslatableRules($rules);
        }

        return $rules;
    }

    /**
     * Merges translatable rules to rules config.
     *
     * @param  array  $rules
     *
     * @return  void
     */
    private function mergeTranslatableRules(&$rules)
    {
        $translatableRules = \collect($this->applyTranslatableRules());

        if ($translatableRules->isNotEmpty()) {
            $translatableRules = $translatableRules->mapWithKeys(function ($rules, $attribute) {
                return ["%" . $attribute . "%" => $rules];
            })->toArray();

            $translatableRules = RuleFactory::make($translatableRules, RuleFactory::FORMAT_ARRAY, "%", "%", $this->getApplyableLocales());
            $translatableActive = RuleFactory::make(['%active%' => 'required']);

            $rules = \array_merge($rules, $translatableRules, $translatableActive);
        }
    }

    /**
     * Returns applyable locales on translatable rules.
     *
     * We filter out the locales that do not
     * have a active status of true.
     *
     * @return  array
     */
    private function getApplyableLocales()
    {
        return \collect(\getLocales())->reject(
            function ($locale) {
                return (\request()->has("{$locale}.active") &&
                    false === (bool) \request()->input("{$locale}.active") &&
                    $locale !== \app()->getLocale());
            }
        )->toArray();
    }

    /**
     * Get the validation rules for attributes that are not translated.
     *
     * @return array
     */
    abstract public function applyRules();
}
