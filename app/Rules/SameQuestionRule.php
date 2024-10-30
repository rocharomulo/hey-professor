<?php

namespace App\Rules;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SameQuestionRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->validationRule($value)) {
            $fail('Question already exists.');
        }
    }

    private function validationRule(string $value): bool
    {
        return Question::whereQuestion($value)->exists();
    }
}
