<?php

namespace App\Providers;

use App\Traits\DiscordTrait;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data = [], $message = 'Success', $statusCode = 200) {
            return Response::json([
                'status' => true,
                'message' => $message,
                'data' => $data,
            ], $statusCode);
        });

        Response::macro('error', function ($message = 'Bad request', $statusCode = 400) {
            $error_msg = 'Aksi gagal ';

            if ($statusCode == 0) $statusCode = 400;

            if ($statusCode > 599) $statusCode = 500;

            if ($statusCode == 500) {
                $message = ((config('services.environment.env') == "local" && config('services.environment.debug') == "true")) ? $error_msg . " [" . $message . "]" : $error_msg;
            }

            return Response::json([
                'status' => false,
                'message' => $message
            ], $statusCode);
        });
    }
}
