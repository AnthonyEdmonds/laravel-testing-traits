<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Container\Container;
use Faker\Generator;

trait UsesFaker
{
    protected function faker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }
}
