<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Container\Container;
use Faker\Generator;

class UsesFaker
{
    protected function faker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }
}
