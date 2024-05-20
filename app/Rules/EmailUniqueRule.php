<?php

namespace App\Rules;

use App\Models\User;
use App\Traits\GlobalTrait;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EmailUniqueRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $exp_email = explode("@", $value);
        $new_email = str_replace(".", "", $exp_email[0]);
        $email_data = User::select(DB::raw("replace(SUBSTRING_INDEX(email, '@', 1), '.', '')"))
            ->whereRaw("replace(SUBSTRING_INDEX(email, '@', 1), '.', '') = ?", $new_email)
            ->first();
        return $email_data ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email sudah terdaftar.';
    }
}
