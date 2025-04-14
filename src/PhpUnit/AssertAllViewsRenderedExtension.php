<?php

namespace AnthonyEdmonds\LaravelTestingTraits\PhpUnit;

use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;

class AssertAllViewsRenderedExtension implements Extension
{
    public function bootstrap(
        Configuration $configuration,
        Facade $facade,
        ParameterCollection $parameters,
    ): void {
        $facade->registerSubscribers(
            new StartLoggingViews(),
            new RecordRenderedViews(),
            new FinishLoggingViews(),
        );
    }

    public static function path(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'viewlist.csv';
    }

    public static function isExcluded(string $view): bool
    {
        $exclude = config('testing-traits.exclude_views', []);

        foreach ($exclude as $term) {
            if (str_contains($view, $term) === true) {
                return true;
            }
        }

        return false;
    }
}
