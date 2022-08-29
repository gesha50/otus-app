<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class QuizObserver
{
    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function created() {
        Cache::forget('quizzes');
        Cache::forget('userQuizzes');
    }

    /**
     * Handle the User "updated" event.
     *
     * @return void
     */
    public function updated()
    {
        Cache::forget('quizzes');
        Cache::forget('userQuizzes');
    }

    /**
     * Handle the User "deleted" event.
     *
     * @return void
     */
    public function deleted()
    {
        Cache::forget('quizzes');
        Cache::forget('userQuizzes');
    }
}
