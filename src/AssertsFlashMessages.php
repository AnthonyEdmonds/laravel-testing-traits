<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

/**
 * Test whether your Laracasts\Flash messages are working properly
 * Simply include this trait on your test and call the assert methods.
 *
 * @author Anthony Edmonds
 *
 * @link https://github.com/AnthonyEdmonds
 */
trait AssertsFlashMessages
{
    public function assertFlashed(string $message, ?string $level = null): void
    {
        $flash = flash()
            ->messages->where('message', $message)
            ->first();

        $this->assertNotNull($flash);

        $this->assertEquals($message, $flash->message);

        if ($level !== null) {
            $this->assertEquals($level, $flash->level);
        }
    }
}
