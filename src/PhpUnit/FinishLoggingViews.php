<?php

namespace AnthonyEdmonds\LaravelTestingTraits\PhpUnit;

use PHPUnit\Event\Application\Finished;
use PHPUnit\Event\Application\FinishedSubscriber;

class FinishLoggingViews implements FinishedSubscriber
{
    public function notify(Finished $event): void
    {
        $raw = file_get_contents(AssertAllViewsRenderedExtension::path()) ?: '';
        $actual = array_unique(
            array_filter(
                explode(',', $raw),
            ),
        );

        $expected = [];

        $this->scanDirectory(
            resource_path('views'),
            $expected,
            '',
        );

        $rendered = array_intersect($actual, $expected);
        $unrendered = array_diff($expected, $actual);
        $total = count($expected);
        $passed = count($rendered);
        $failed = count($unrendered);
        $percent = ceil(($passed / $total) * 100);
        $resultsPath = $this->resultsPath();

        file_put_contents($resultsPath, json_encode([
            'failed' => $failed,
            'passed' => $passed,
            'percent' => $percent,
            'rendered' => array_values($rendered),
            'result' => $failed === 0 ? 'Pass' : 'Fail',
            'state' => $failed === 0 ? 1 : -1,
            'total' => $total,
            'unrendered' => array_values($unrendered),
        ]));

        echo $failed > 0
            ? "$failed views were not rendered; results have been saved in $resultsPath"
            : "All views were rendered; results have been saved in $resultsPath";
    }

    protected function resultsPath(): string
    {
        return base_path('.phpunit.cache') . DIRECTORY_SEPARATOR . 'view-render-results.json';
    }

    protected function scanDirectory(string $basepath, array &$expected, string $prefix): void
    {
        $paths = scandir($basepath);

        foreach ($paths as $filename) {
            if (in_array($filename, ['.', '..']) === true) {
                continue;
            }

            $filepath = $basepath . DIRECTORY_SEPARATOR . $filename;

            if (is_dir($filepath) === true) {
                $this->scanDirectory($filepath, $expected, "$prefix$filename.");

            } elseif (is_file($filepath) === true) {
                $name = $prefix . str_replace('.blade.php', '', $filename);

                if (AssertAllViewsRenderedExtension::isExcluded($name) === true) {
                    continue;
                }

                $expected[] = $name;
            }
        }
    }
}
