<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\StartScreen;
use App\Observers\CategoryObserver;
use App\Observers\QuestionObserver;
use App\Observers\QuizObserver;
use App\Observers\StartScreenObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);
        Quiz::observe(QuizObserver::class);
        StartScreen::observe(StartScreenObserver::class);
        Question::observe(QuestionObserver::class);
    }
}
