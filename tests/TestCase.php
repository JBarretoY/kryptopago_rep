<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase, CreatesApplication;

    private $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    /**
     * @param array $attributes
     * @return \App\Models\User
     */
    protected function actingAsUser($attributes = [])
    {
        $user = factory('App\Models\User')->create($attributes);

        $token = auth()->attempt([
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $this->headers = array_merge($this->headers, ['HTTP_Authorization' => 'Bearer ' . $token]);

        return $user;
    }


    /**
     * @return array
     */
    protected function getHeaders()
    {
        return $this->headers;
    }

}
