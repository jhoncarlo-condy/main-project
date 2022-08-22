<?php

namespace Modules\Contact\Rules;

use Illuminate\Contracts\Validation\Rule;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class ContactInfoDynamicRule implements Rule
{
    private string $column_value;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(protected $type)
    {
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
        $array = explode('.', $attribute);
        end($array);
        $index = prev($array);

        $this->column_value = strtolower($this->type[$index]);

        if ($this->column_value === 'email') {
            return (new EmailValidator())->isValid($value, new RFCValidation());
            // } else if($this->column_value === 'phone') {
            //     return preg_match('/\+([0-9][0-9])[0-9]{9}$/', $value) && (strlen($value) >= 10 || strlen($value) <= 15);
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch ($this->column_value) {
            case 'email':
                return 'The :attribute is invalid email address.';
                break;

            case 'phone':
                return 'The :attribute is invalid phone number. Example format (+xxxxxxxxxxx)';
                break;

            default:
                return 'The :attribute is invalid value.';
                break;
        }
    }
}
