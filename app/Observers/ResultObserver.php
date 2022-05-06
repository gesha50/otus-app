<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class ResultObserver
{
    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function created() {
        Cache::forget('results');
    }

    /**
     * Handle the User "updated" event.
     *
     * @return void
     */
    public function updated()
    {
        Cache::forget('results');
    }

    /**
     * Handle the User "deleted" event.
     *
     * @return void
     */
    public function deleted()
    {
        Cache::forget('results');
    }
}
