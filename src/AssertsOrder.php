<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Support\Collection;

/**
 * Test your array of items is in order; simply pass in an array of values
 *
 * @author Anthony Edmonds
 *
 * @link https://github.com/AnthonyEdmonds
 */
trait AssertsOrder
{
    protected function assertAscending(Collection $items, string $key = 'id'): void
    {
        $items = $items->pluck($key);
        $last = null;

        foreach ($items as $item) {
            if ($last !== null) {
                $this->assertTrue($item >= $last);
            }

            $last = $item;
        }
    }

    protected function assertDescending(Collection $items, string $key = 'id'): void
    {
        $items = $items->pluck($key);
        $last = null;

        foreach ($items as $item) {
            if ($last !== null) {
                $this->assertTrue($item <= $last);
            }

            $last = $item;
        }
    }
}
