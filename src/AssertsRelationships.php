<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase;

/**
 * Test whether your Model relationships are working properly
 * Simply include this trait on your test and call the assert methods.
 *
 * @author Anthony Edmonds
 *
 * @link https://github.com/AnthonyEdmonds
 * @mixin TestCase
 */
trait AssertsRelationships
{
    public function assertBelongsTo(
        Model $model,
        string $relationship,
        string $expectedClass,
    ): void {
        $this->assertInstanceOf($expectedClass, $model->$relationship);
    }

    public function assertBelongsToMany(
        Model $model,
        string $relationship,
        string $expectedClass,
        int $expectedCount = 3,
    ): void {
        $this->assertHasMany($model, $relationship, $expectedClass, $expectedCount);
    }

    public function assertHasMany(
        Model $model,
        string $relationship,
        string $expectedClass,
        int $expectedCount = 3,
    ): void {
        $this->assertCount($expectedCount, $model->$relationship);

        foreach ($model->$relationship as $related) {
            $this->assertInstanceOf($expectedClass, $related);
        }
    }

    public function assertHasOne(
        Model $model,
        string $relationship,
        string $expectedClass,
    ): void {
        $this->assertInstanceOf($expectedClass, $model->$relationship);
    }
}
