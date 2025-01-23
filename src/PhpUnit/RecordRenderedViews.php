<?php

namespace AnthonyEdmonds\LaravelTestingTraits\PhpUnit;

use Illuminate\Support\Facades\Event;
use PHPUnit\Event\Test\BeforeFirstTestMethodCalled;
use PHPUnit\Event\Test\BeforeFirstTestMethodCalledSubscriber;

class RecordRenderedViews implements BeforeFirstTestMethodCalledSubscriber
{
    public function notify(BeforeFirstTestMethodCalled $event): void
    {
        Event::listen('composing:*', function (string $view) {
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
