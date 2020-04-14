<?php

namespace LegoCMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\SoftDeletes;
use LegoCMS\Models\Behaviours\IsTranslatable;
use LegoCMS\Models\Behaviours\IsRevisionable;
use LegoCMS\Models\Listeners\ModelSaved;

/**
 * Class BaseModel
 *
 * @category Models
 * @package  LegoCMS\Models
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Models/BaseModel.php
 */
abstract class BaseModel extends Model
{
    use SoftDeletes, IsTranslatable, IsRevisionable;

    public $timestamps = true;

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that are are translated.
     *
     * @var  array
     */
    public $translatedAttributes = [];


    // /**
    //  * The event map for the model.
    //  *
    //  * @var array
    //  */
    // protected $dispatchesEvents = [
    //     'saved' => ModelSaved::class,
    // ];

    protected static function booted()
    {
        $class = static::class;
        foreach (\class_uses_recursive($class) as $trait) {
            $method = 'booted' . \class_basename($trait);

            if (\method_exists($class, $method)) {
                \forward_static_call([$class, $method]);
            }
        }
    }

    /**
     * Applies scope for returning only published models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->wherePublished(true);
    }

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

        // Resolve fillables for Translation Model from Base Model.
        if (\blank($fillable) && Str::contains(\get_class($this), 'Models\Translations')) {
            $baseModelClass =  $this->resolveModelNameFromTranslationModel();
            $fillable = (new $baseModelClass)->getTranslatedAttributes();

            if (!Arr::has($fillable, 'active')) {
                $fillable[] = 'active';
            }

            if (!Arr::has($fillable, 'locale')) {
                $fillable[] = 'locale';
            }
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
     * Resolves BaseModel name from Translation Model.
     *
     * @return  string
     */
    protected function resolveModelNameFromTranslationModel()
    {
        return $this->resolveNameSpace() . "Models\\" . \str_replace('Translation', '', \class_basename(static::class));
    }

    /**
     * Returns module name.
     *
     * @return string
     */
    protected function getModuleName()
    {
        return Str::snake(Str::plural(\class_basename(static::class)));
    }

    /**
     * Returns singular module name.
     *
     * @return string
     */
    public function getSingularModuleName()
    {
        return Str::snake(\class_basename(static::class));
    }

    /**
     * Resolves Namespace.
     *
     * @return string
     */
    protected function resolveNameSpace()
    {
        $domain = "Models\\";

        if (Str::contains($class = static::class, 'Models\Translations')) {
            $domain .= "Translations\\";
        }

        return \str_replace($domain . \class_basename(static::class), "", static::class);
    }
}
