<?php

namespace LegoCMS\Http\Controllers\Admin\Behaviours;

trait HandlesFlashNotifications
{
    protected function notifySuccess($message, $title = "Success!")
    {
        $this->notify($title, $message, 'success');
    }

    protected function notifyError($message, $title = "Error!")
    {
        $this->notify($title, $message, 'error');
    }

    protected function notifyWarning($message, $title = "Warning!")
    {
        $this->notify($title, $message, 'warning');
    }

    protected function notifyInfo($message, $title = "Info!")
    {
        $this->notify($title, $message, 'info');
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
