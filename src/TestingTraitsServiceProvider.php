<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use AnthonyEdmonds\LaravelTestingTraits\PhpUnit\AssertAllViewsRenderedExtension;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class TestingTraitsServiceProvider extends ServiceProvider
{
    protected array $exclusions = [];

    public function register(): void
    {
        $this->publishes([
            __DIR__ . '/testing-traits.php' => config_path('testing-traits.php'),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/testing-traits.php', 'testing-traits');
    }

    public function boot(): void
    {
        if ($this->app->runningUnitTests() === true) {
            $this->exclusions = config('testing-traits.exclude_views', []);

            Event::listen('composing:*', function (string $view) {
                if (AssertAllViewsRenderedExtension::isExcluded($view, $this->exclusions) === false) {
                    file_put_contents(
                        AssertAllViewsRenderedExtension::renderedPath(),
                        substr($view, 11) . ',',
                        FILE_APPEND | LOCK_EX,
                    );
                }
            });
        }
    }
}
