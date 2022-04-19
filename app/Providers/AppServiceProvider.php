<?php

namespace App\Providers;

use App\Actions\Socialstream\AlKhidmahAccountProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* $socialite = $this->app->make(Factory::class);
        $socialite->extends(
            'alkhidmah',
            fn() => $socialite->buildProvider(AlKhidmahAccountProvider::class, config('services.alkhidmah'))
        ); */
    }
}
