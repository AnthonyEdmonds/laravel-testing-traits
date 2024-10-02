<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase;

/**
 * Assert whether an activity has been logged for the given subject
 *
 * @author Anthony Edmonds
 *
 * @link https://github.com/AnthonyEdmonds
 * @mixin TestCase
 */
trait AssertsActivities
{
    public function assertActivity(
        Model $subject,
        string $event,
        ?string $description = null,
        ?array $attributes = null,
        ?array $old = null,
        ?array $extras = null,
    ): void {
        $activity = $subject->activities->where('event', $event)->last();

        $this->assertNotNull($activity);

        if ($description !== null) {
            $this->assertEquals($description, $activity->description);
        }

        if ($attributes !== null) {
            $this->assertEquals($attributes, $activity->getExtraProperty('attributes'));
        }

        if ($old !== null) {
            $this->assertEquals($old, $activity->getExtraProperty('old'));
        }

        if ($extras !== null) {
            foreach ($extras as $key => $value) {
                $this->assertEquals($value, $activity->getExtraProperty($key));
            }
        }
    }
}
