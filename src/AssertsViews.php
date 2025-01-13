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
