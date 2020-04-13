<?php

namespace LegoCMS\Http\Controllers\Admin\Behaviours;

trait HandlesFlashNotifications
{
    protected function notifySuccess($message, $title = "Success!!!")
    {
        $this->notify($title, $message, 'success');
    }

    protected function notify($title, $message, $type)
    {
        \request()->session()->flash('listingsNotifications', [
            'type' => $type,
            'title' => $title,
            'message' => $message
        ]);
    }
}
