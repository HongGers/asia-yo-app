<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PriceOverLimitRule implements ValidationRule
{
    private $limit;

    public function __construct(int $limit = 2000)
    {
        $this->limit = $limit;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $limit = $this->limit;
        if ($value > $limit) {
            $fail("$attribute is over $limit");
        }
    }
}
