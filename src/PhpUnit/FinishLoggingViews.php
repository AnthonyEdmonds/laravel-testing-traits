<?php

namespace AnthonyEdmonds\LaravelTestingTraits\PhpUnit;

use PHPUnit\Event\Application\Finished;
use PHPUnit\Event\Application\FinishedSubscriber;

class FinishLoggingViews implements FinishedSubscriber
{
    public function notify(Finished $event): void
    {
        $raw = file_get_contents(AssertAllViewsRenderedExtension::path()) ?: '';
        $actual = array_filter(
            explode(',', $raw),
        );

        $expected = [];

        $this->scanDirectory(
            resource_path('views'),
            $expected,
            '',
        );

        $unrendered = array_diff($expected, $actual);
        $total = count($expected);
        $passed = count($actual);
        $failed = count($unrendered);
        $percent = ceil(($passed / $total) * 100);
        $resultsPath = $this->resultsPath();

        file_put_contents($resultsPath, json_encode([
            'failed' => $failed,
            'passed' => $passed,
            'percent' => $percent,
            'rendered' => $actual,
            'result' => $failed === 0 ? 'Pass' : 'Fail',
            'total' => $total,
            'unrendered' => $unrendered,
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
            if (in_array($filename, ['.', '..', 'vendor']) === true) {
                continue;
            }

            $filepath = $basepath . DIRECTORY_SEPARATOR . $filename;

            if (is_dir($filepath) === true) {
                $this->scanDirectory($filepath, $expected, "$prefix$filename.");

            } elseif (is_file($filepath) === true) {
                $expected[] = $prefix . str_replace('.blade.php', '', $filename);
            }
        }
    }
}
