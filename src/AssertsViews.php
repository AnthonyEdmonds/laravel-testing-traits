<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Contracts\View\View;

trait AssertsViews
{
    use SetsViewVariables;

    public function assertViewRenders(
        View $view,
        array $attributes = [],
        array $errors = [],
        array $old = [],
        array $slots = [],
    ): void {
        // Get list of views rendered by framework. I think it was in app?
        $this->app['events']->listen('composing:*', function ($view) {
            // Would be best as a single file write for all events...
            file_put_contents(__DIR__ . 'viewlist.csv', $view->name().',', FILE_APPEND | LOCK_EX);
        });

        $this->setViewAttributes($attributes);
        $this->setViewErrors($errors);
        $this->setRequestOld($old);

        foreach ($slots as $slot) {
            $this->setViewSlot(
                $slot['name'] ?? '',
                    $slot['html'] ?? '',
                    $slot['data'] ?? [],
            );
        }

        $this->assertIsString(
            $view->render(),
            $view->name() . ' failed to render',
        );
    }
}
