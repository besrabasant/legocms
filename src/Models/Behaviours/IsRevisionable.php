<?php

namespace LegoCMS\Models\Behaviours;

/**
 * trait IsRevisionable
 */
trait IsRevisionable
{
    /**
     * Check if the model is revisionable.
     *
     * @return  boolean
     */
    public function isRevisionable()
    {
        return \classHasTrait($this, \LegoCMS\Models\Behaviours\HasRevisions::class);
    }
}
