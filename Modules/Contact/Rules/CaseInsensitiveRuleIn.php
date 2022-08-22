<?php

namespace Modules\Contact\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class CaseInsensitiveRuleIn implements Rule
{
    use ValidatesAttributes;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        protected array $choices
    ) {
        $this->choices = array_map('strtolower', $choices);
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
        $value = strtolower($value);

        return $this->validateIn($attribute, $value, $this->choices);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Invalid value for :attribute. Must be one of the following: " . implode(", ", $this->choices);
    }
}
