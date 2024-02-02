<?php

namespace App\Traits;

trait HasAlertAfterAction
{
    /**
     * Alert Succeed
     * Note: Only use for Laravel blade
     *
     * @param string $message
     * @param bool $isSucceed
     * @return void
     */
    protected function alertAfterHandling(string $message, bool $isSucceed = true)
    {
        session()->flash('status', $isSucceed);
        session()->flash('action-message', $message);
    }

    /**
     * Alert Error
     * Note: Only use for Laravel blade
     *
     * @param string $message
     * @return void
     */
    protected function alertError(string $message)
    {
        session()->flash('error', $message);
    }

    /**
     * Alert Error
     * Note: Only use for Laravel blade
     *
     * @param string $message
     * @return void
     */
    protected function alertMessage(string $message)
    {
        session()->flash('message', $message);
    }
}
