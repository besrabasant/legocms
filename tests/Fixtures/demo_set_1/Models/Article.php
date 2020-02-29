<?php

namespace DemoSet1\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use LegoCMS\Models\BaseModel;
use LegoCMS\Models\Behaviours\HasTranslations;
use LegoCMS\Models\Behaviours\HasRevisions;

class Article extends BaseModel implements TranslatableContract
{
    use HasTranslations, HasRevisions;

    protected $fillable = [
        'author',
        'email'
    ];

    public $translatedAttributes = [
        'name',
        'description'
    ];
}
