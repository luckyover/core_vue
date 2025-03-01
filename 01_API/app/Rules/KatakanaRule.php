<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class KatakanaRule implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value === null || $value === '') {
            return true;
        }

        return preg_match('/[\p{L}\p{N}\p{Katakana}]+/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'E005';
    }
}
