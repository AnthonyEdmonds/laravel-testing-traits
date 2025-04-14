<?php

namespace AnthonyEdmonds\LaravelTestingTraits\PhpUnit;

use Illuminate\Support\Facades\Event;
use PHPUnit\Event\Test\Prepared;
use PHPUnit\Event\Test\PreparedSubscriber;

class RecordRenderedViews implements PreparedSubscriber
{
    public function notify(Prepared $event): void
    {
        Event::listen('composing:*', function (string $view) {
            if (AssertAllViewsRenderedExtension::isExcluded($view) === false) {
                file_put_contents(
                    AssertAllViewsRenderedExtension::path(),
                    substr($view, 11) . ',',
                    FILE_APPEND | LOCK_EX,
                );
            }
        });
    }
}
