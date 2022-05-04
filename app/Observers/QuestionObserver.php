<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class QuestionObserver
{
    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function created() {
        Cache::forget('questions');
    }

    /**
     * Handle the User "updated" event.
     *
     * @return void
     */
    public function updated()
    {
        Cache::forget('questions');
    }

    /**
     * Handle the User "deleted" event.
     *
     * @return void
     */
    public function deleted()
    {
        Cache::forget('questions');
    }
}
