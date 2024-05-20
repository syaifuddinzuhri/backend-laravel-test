<?php

use App\Models\User;

if (!function_exists('getAuthUser')) {
    function getAuthUser()
    {
        if (auth('api')->user()) {
            return User::find(auth('api')->user()->id);
        }
        return NULL;
    }
}
