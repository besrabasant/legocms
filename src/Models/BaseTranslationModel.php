<?php

namespace LegoCMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use LegoCMS\Models\Behaviours\IsTranslatable;

/**
 * Class BaseTranslationModel
 *
 * @category Models
 * @package  LegoCMS\Models
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Models/BaseTranslationModel.php
 */
abstract class BaseTranslationModel extends Model
{
    use IsTranslatable;

    /**
     * The attributes that are are translated.
     *
     * @var  array
     */
    public $translatedAttributes = [];

    /**
     * Applies scope for returning only drafted models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft($query)
    {
        return $query->wherePublished(false);
    }

    /**
     * Applies scope for returning only deleted models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyTrashed($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    /**
     * Returns model fillable attributes.
     *
     * @return  array
     */
    public function getFillable()
    {
        // If the fillable attribute is filled, just use it
        $fillable = $this->fillable;

        // if it's a translable model
        // Use the list of translatable attributes on the model
        if ($this->isTranslatable()) {
            $translatedFillable = $this->getTranslatedAttributes();

            // if (!Arr::has($translatedFillable, 'locale')) {
            //     $translatedFillable[] = 'locale';
            // }

            if (!Arr::has($translatedFillable, 'active')) {
                $translatedFillable[] = 'active';
            }

            $locales = \getLocales();

            $fillable = \collect($translatedFillable)->reduce(function ($acc, $attribute) use ($locales) {
                foreach ($locales as $locale) {
                    \array_push($acc, $locale . "." . $attribute);
                }
                return $acc;
            }, $fillable);
        }

        return $fillable;
    }

    /**
     * Returns Translated attributes.
     *
     * @return  array
     */
    public function getTranslatedAttributes()
    {
        return $this->translatedAttributes ?? [];
    }

    /**
     * Resolves Namespace.
     *
     * @return string
     */
    protected function resolveNameSpace()
    {
        return \str_replace("Models\\" . \class_basename(static::class), "", static::class);
    }
}
