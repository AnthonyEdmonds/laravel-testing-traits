<?php

namespace AnthonyEdmonds\LaravelTestingTraits\PhpUnit;

use Illuminate\Support\Facades\Event;
use PHPUnit\Event\Test\Prepared;
use PHPUnit\Event\Test\PreparedSubscriber;

// TODO Facade not registered in global state / isolate
class RecordRenderedViews implements PreparedSubscriber
{
    protected array $exclusions = [];

    public function notify(Prepared $event): void
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
