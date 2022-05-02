<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function created() {
        Cache::forget('categories');
    }

    /**
     * Handle the User "updated" event.
     *
     * @return void
     */
    public function updated()
    {
        Cache::forget('categories');
    }

    /**
     * Handle the User "deleted" event.
     *
     * @return void
     */
    public function deleted()
    {
        Cache::forget('categories');
    }
}
