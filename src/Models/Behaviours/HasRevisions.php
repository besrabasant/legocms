<?php

namespace LegoCMS\Models\Behaviours;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * trait HasRevisions.
 *
 * @mixin \LegoCMS\Models\BaseModel
 */
trait HasRevisions
{
    protected static function bootedHasRevisions()
    {
        static::saved(function ($model) {

            $revisionPayload = $model->prepareRevision();

            $lastRevisionPayload = \json_decode($model->revisions->first()->payload ?? "{}", true);

            if ($revisionPayload !== $lastRevisionPayload) {
                $model->revisions()->create([
                    'payload' => \json_encode($revisionPayload),
                    'user_id' => Auth::guard('legocms_users')->user()->id ?? null
                ]);
            }
        });
    }

    public function prepareRevision()
    {
        $revision = [];

        foreach ($this->getFillable() as $field) {
            $attributesArr = \explode('.', $field);

            if (count($attributesArr) == 2) {
                $revision[$attributesArr[0]][$attributesArr[1]] = $this->translate($attributesArr[0])
                    ->getAttribute($attributesArr[1]);
            } else {
                $revision[$field] = $this->getAttribute($field);
            }
        }

        return $revision;
    }

    /**
     * Restores revision to and returns a new Model Instance.
     *
     * @param  \LegoCMS\Models\Revision  $revision
     *
     * @return  \LegoCMS\Models\BaseModel
     */
    public function hydrateRevision($revision)
    {
        $payload = \json_decode($revision->payload, true);
        return $this->newInstance($payload);
    }

    /**
     * Restores revision to model.
     *
     * @param  \LegoCMS\Models\Revision  $revision
     *
     * @return  \LegoCMS\Models\BaseModel
     */
    public function restoreRevision($revision)
    {
        $payload = \json_decode($revision->payload, true);

        $this->fill($payload);

        $this->save();

        return $this;
    }

    /**
     * Returns Revision Model name.
     *
     * @return  string
     */
    public function getRevisionsModelName()
    {
        return $this->resolveNamespace() . "Models\Revisions\\" . \class_basename($this) . "Revision";
    }

    /**
     * Model Revisions relationship
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function revisions()
    {
        return $this->hasMany($this->getRevisionsModelName())->orderBy('created_at', 'desc');
    }

    public function scopeMine($query)
    {
        return $query->whereHas('revisions', function ($query) {
            $query->where('user_id', \auth('legocms_users')->user()->id);
        });
    }

    /**
     * Returns revisions array.
     *
     * @return  array
     */
    public function revisionsArray()
    {
        return $this->revisions->map(function ($revision) {
            return [
                'id' => $revision->id,
                'url' => \moduleRoute(
                    $this->getModuleName(),
                    'previewRevision',
                    [
                        Str::slug($this->getSingularModuleName()) => $this->id,
                        'revision' => $revision->id
                    ]
                ),
                'author' => $revision->user->name ?? 'Unknown',
                'datetime' => $revision->created_at->toDayDateTimeString(),
            ];
        })->toArray();
    }
}
