<?php

namespace LegoCMS\Http\Controllers\Admin\Behaviours;

trait HandlesRevisions
{
    /**
     * Controller restoreRevision method.
     *
     * @param  string|int  $id
     * @param  string|int  $revisionId
     *
     * @return  RedirectResponse
     */
    public function restoreRevision($id, $revisionId)
    {
        /** @var \LegoCMS\Models\BaseModel */
        $model = $this->getModelName()::find($id);

        /** @var \LegoCMS\Models\Revision */
        $revision = $model->revisions()->find($revisionId);

        // We Restore the revision.
        $model->restoreRevision($revision);

        return $this->returnToIndexRoute(); // TODO: return to proper route.
    }

    /**
     * Controller deleteRevision method.
     *
     * @param  string|int  $id
     * @param  string|int  $revisionId
     *
     * @return  RedirectResponse
     */
    public function deleteRevision($id, $revisionId)
    {
        /** @var \LegoCMS\Models\Revision */
        $revision = $this->getModelRevisionName()::find($revisionId);

        // We delete the revision.
        $revision->delete();

        return $this->returnToIndexRoute(); //TODO: return to proper route.
    }


    /**
     * Returns Model name.
     *
     * @return string
     */
    public function getModelRevisionName()
    {
        return "{$this->getNamespace()}Models\Revisions\\{$this->resolveModelNameFromController()}Revision";
    }
}
