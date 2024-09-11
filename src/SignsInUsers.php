<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait SignsInUsers
{
    public function signIn(?Model $user = null): Model
    {
        if ($user === null) {
            /** @var class-string<Model> $userClass */
            $userClass = config('testing-traits.user_model');
            $user = $userClass::factory()->create();
        }

        Auth::login($user);

        return $user;
    }

    public function signInAs(Model $user): Model
    {
        return $this->signIn($user);
    }

    public function signInWithRole(string $role, ?Model $user = null): Model
    {
        return $this->signIn($user)->assignRole($role);
    }

    public function signInWithPermission(string $permission, ?Model $user = null): Model
    {
        return $this->signIn($user)->givePermissionTo($permission);
    }
}
