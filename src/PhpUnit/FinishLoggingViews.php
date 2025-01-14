<?php

namespace AnthonyEdmonds\LaravelTestingTraits\PhpUnit;

use PHPUnit\Event\Application\Finished;
use PHPUnit\Event\Application\FinishedSubscriber;

class FinishLoggingViews implements FinishedSubscriber
{
    public function notify(Finished $event): void
    {
        $raw = file_get_contents(__DIR__ . 'viewlist.csv');
        $files = explode(',', $raw);

        dd($files);

        // List expected views
        // Kill if failed?
    }
}
