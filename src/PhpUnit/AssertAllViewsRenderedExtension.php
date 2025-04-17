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
            new FinishLoggingViews(),
        );
    }

    // Exclusions
    public static function exclusions(): array
    {
        return self::config()['exclude_views'];
    }

    public static function isExcluded(string $view, ?array $exclusions = null): bool
    {
        if ($exclusions === null) {
            $exclusions = self::exclusions();
        }

        foreach ($exclusions as $term) {
            if (str_contains($view, $term) === true) {
                return true;
            }
        }

        return false;
    }

    // Config
    protected static function config(): array
    {
        $defaultConfig = require self::defaultConfigPath();
        $configPath = self::configPath();

        if (file_exists($configPath) === false) {
            return $defaultConfig;
        }

        $config = require $configPath;

        foreach ($defaultConfig as $key => $value) {
            if (array_key_exists($key, $config) === false) {
                $config[$key] = $value;
            }
        }

        return $config;
    }

    // Paths
    public static function configPath(): string
    {
        return self::path('config', 'testing-traits.php');
    }

    public static function defaultConfigPath(): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            __DIR__,
            '..',
            'testing-traits.php',
        ]);
    }

    public static function renderedPath(): string
    {
        return self::path('.phpunit.cache', 'views-rendered.csv');
    }

    public static function resourcePath(): string
    {
        return self::path('resources', 'views');
    }

    public static function resultsPath(): string
    {
        return self::path('.phpunit.cache', 'views-results.json');
    }

    protected static function path(string ...$paths): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            __DIR__,
            '..',
            '..',
            '..',
            '..',
            '..',
            ...$paths,
        ]);
    }
}
