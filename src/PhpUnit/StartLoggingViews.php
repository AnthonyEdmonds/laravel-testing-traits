<?php

namespace AnthonyEdmonds\LaravelTestingTraits\PhpUnit;

use PHPUnit\Event\Application\Started;
use PHPUnit\Event\Application\StartedSubscriber;

class StartLoggingViews implements StartedSubscriber
{
    public function notify(Started $event): void
    {
        file_put_contents(AssertAllViewsRenderedExtension::renderedPath(), '', LOCK_EX);
    }
}
