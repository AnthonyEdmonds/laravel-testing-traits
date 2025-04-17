<?php

namespace AnthonyEdmonds\LaravelTestingTraits\PhpUnit;

use Illuminate\Support\Facades\Event;
use PHPUnit\Event\Test\BeforeFirstTestMethodCalled;
use PHPUnit\Event\Test\BeforeFirstTestMethodCalledSubscriber;

class RecordRenderedViews implements BeforeFirstTestMethodCalledSubscriber
{
    protected array $exclusions = [];

    public function notify(BeforeFirstTestMethodCalled $event): void
    {
        $this->exclusions = AssertAllViewsRenderedExtension::exclusions();

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
