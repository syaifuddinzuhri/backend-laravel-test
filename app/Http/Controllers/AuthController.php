<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $repository;

    public function __construct()
    {
        $this->repository = new AuthRepository();
    }

    public function login(LoginRequest $request)
    {
        try {
            $data = $this->repository->login($request);
            return response()->success($data, 'Login berhasil.');
        } catch (\Throwable $e) {
            return response()->error($e->getMessage());
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $this->repository->register($request);
            return response()->success($data, 'Register berhasil.');
        } catch (\Throwable $e) {
            return response()->error($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $data = $this->repository->logout();
            return response()->success($data, 'Logout berhasil.');
        } catch (\Throwable $e) {
            return response()->error($e->getMessage());
        }
    }
}
