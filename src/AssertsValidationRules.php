<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Testing\TestCase;

/**
 * Test that your Laravel ValidationRules work as expected
 *
 * @author Anthony Edmonds
 *
 * @link https://github.com/AnthonyEdmonds
 * @mixin TestCase
 */
trait AssertsValidationRules
{
    protected function assertRulePasses(
        ValidationRule $rule,
        string $attribute,
        mixed $value,
    ): void {
        $passed = true;

        $rule->validate($attribute, $value, function (string $error) use (&$passed) {
            $passed = false;

            $this->fail("Rule failed when it should pass: $error");
        });

        if ($passed === true) {
            $this->assertTrue(true);
        }
    }

    protected function assertRuleFails(
        ValidationRule $rule,
        string $attribute,
        mixed $value,
        ?string $message = null,
    ): void {
        $passed = true;

        $rule->validate($attribute, $value, function (string $error) use ($message, &$passed) {
            $passed = false;

            $message !== null
                ? $this->assertEquals($message, $error)
                : $this->assertTrue(true);
        });

        if ($passed === true) {
            $this->fail('Rule passed when it should fail');
        }
    }
}
