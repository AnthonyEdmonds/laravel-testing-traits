<?php

namespace AnthonyEdmonds\LaravelTestingTraits\PhpUnit;


use PHPUnit\Event\Test\Prepared;
use PHPUnit\Event\Test\PreparedSubscriber;

class RecordRenderedViews implements PreparedSubscriber
{
    public function notify(Prepared $event): void
    {
        app('events')->listen('composing:*', function (string $view) {
            if (str_contains($view, '::') === false) {
                file_put_contents(
                    AssertAllViewsRenderedExtension::path(),
                    substr($view, 11) . ',',
                    FILE_APPEND | LOCK_EX,
                );
            }
        });
    }
}
