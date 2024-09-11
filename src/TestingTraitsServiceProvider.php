<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Support\ServiceProvider;

class TestingTraitsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->publishes([
            __DIR__ . '/testing-traits.php' => config_path('testing-traits.php'),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/testing-traits.php', 'testing-traits');
    }

    public function boot(): void
    {
        //
    }
}
