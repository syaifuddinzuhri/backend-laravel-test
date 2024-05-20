<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\GlobalTrait;

class AuthRepository
{
    use GlobalTrait;

    public function login($request)
    {
        try {
            $credentials = $request->only(['email', 'password']);

            if (!$token = auth('api')->attempt($credentials)) {
                $this->ApiException("email atau password salah", 401);
            };
            $data = getAuthUser();
            $data['token'] = $token;
            return $data;
        } catch (\Exception $e) {
            throw $e;
            report($e);
            return $e;
        }
    }

    public function register($request)
    {
        try {
            $payload = $request->only(['email', 'password']);
            $result = User::create($payload);
            return $result;
        } catch (\Exception $e) {
            throw $e;
            report($e);
            return $e;
        }
    }

    public function logout()
    {
        try {
            return auth('api')->logout();
        } catch (\Exception $e) {
            throw $e;
            report($e);
            return $e;
        }
    }
}
