<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Auth\Access\Response;

trait AssertsPolicies
{
    protected function assertPolicyAllows(Response $response, string $expectedMessage): void
    {
        $this->assertTrue($response->allowed());
        $this->assertEquals($expectedMessage, $response->message());
    }

    protected function assertPolicyDenies(Response $response, string $expectedMessage): void
    {
        $this->assertFalse($response->allowed());
        $this->assertEquals($expectedMessage, $response->message());
    }
}
