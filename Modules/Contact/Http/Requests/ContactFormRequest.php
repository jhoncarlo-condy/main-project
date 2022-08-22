<?php

namespace Modules\Contact\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Contact\Rules\ContactFormRule;

class ContactFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $contactRules = (new ContactFormRule());
        return request()->isMethod('PUT') ? $contactRules->rulesUpdate() : $contactRules->rulesStore();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
