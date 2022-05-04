<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class AnswerObserver
{
    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function created() {
        Cache::forget('answers');
    }

    /**
     * Handle the User "updated" event.
     *
     * @return void
     */
    public function updated()
    {
        Cache::forget('answers');
    }

    /**
     * Handle the User "deleted" event.
     *
     * @return void
     */
    public function deleted()
    {
        Cache::forget('answers');
    }
}
