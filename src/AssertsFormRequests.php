<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * Test your Laravel FormRequests without pulling your hair out!
 * Simply include this trait on your test and call the assert methods.
 *
 * @author Anthony Edmonds
 *
 * @link https://github.com/AnthonyEdmonds
 */
trait AssertsFormRequests
{
    protected function assertFormRequestPasses(FormRequest $request, ?Model $user = null)
    {
        $validator = $this->runFormRequest($request, $user);

        $this->assertTrue($validator, $validator);
    }

    protected function assertFormRequestFails(FormRequest $request, ?string $message = null, ?Model $user = null)
    {
        $result = $this->runFormRequest($request, $user);

        $message !== null
            ? $this->assertEquals($message, $result, 'The validator did not throw the expected message')
            : $this->assertIsString($result, 'The form request passed when it was supposed to fail');
    }

    protected function runFormRequest(FormRequest $request, ?Model $user = null): bool|string
    {
        if ($user !== null) {
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
        }

        /** @var Validator $validator */
        $validator = $this->app['validator']->make($request->query->all(), $request->rules());

        return $validator->passes() === true
            ? true
            : $validator->messages()->first();
    }
}
