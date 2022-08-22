<?php

namespace Modules\Contact\Rules;

use Illuminate\Validation\Rule;
use Modules\Contact\Rules\CaseInsensitiveRuleIn;

class ContactFormRule
{

    public function __construct()
    {
        //
    }

    public function rulesStore($group = '', $inputs = []): array
    {
        $inputs = $inputs ?? request()->all();
        return array_merge(
            [
                'organization_id' => ['nullable', 'integer', 'exists:organizations,id,deleted_at,NULL'],
                'first_name' => ['required', 'string', 'max:256'],
                'middle_name' => ['nullable', 'string', 'max:256'],
                'last_name' => ['required', 'string', 'max:256'],
                'title' => ['nullable', 'string', 'max:64'],
                'owner_id' => ['nullable', 'integer', 'exists:users,id'],
            ],
            $this->emailArray($group),
            $this->extraRuleSet($group),
            // $this->eavRule->rules(),
        );
    }

    public function rulesUpdate($group = '', $inputs = []): array
    {
        $inputs = $inputs ?? request()->all();

        return array_merge(
            [
                'first_name' => ['sometimes', 'string', 'max:128'],
                'middle_name' => ['sometimes', 'string', 'max:128'],
                'last_name' => ['sometimes', 'string', 'max:128'],
                'title' => ['sometimes', 'string', 'max:64'],
                'organization_id' => ['sometimes', 'integer', 'exists:organizations,id,deleted_at,NULL'],
                'owner_id' => ['nullable', 'integer', 'exists:users,id'],
            ],
            $this->emailArray($group),
            $this->extraRuleSet($group),
            $this->extraRuleSetUpdate($group),
            // $this->eavRule->rules()
        );
    }

    private function extraRuleSet($group = ''): array
    {
        $rules = [
            'contact_info' => ['array'],
            'contact_info.*' => [Rule::in(['add', 'update', 'remove'])],

            'contact_info.add' => ['array'],
            'contact_info.add.*.label' => ['required','string', new CaseInsensitiveRuleIn(['work', 'home', 'mobile', 'other'])],
            'contact_info.add.*.type' => ['required','string', new CaseInsensitiveRuleIn(['email', 'phone'])],
            'contact_info.add.*.value' => ['required_with:type', 'string', 'max:128', new ContactInfoDynamicRule(request()->input($group . 'contact_info.add.*.type'))],
            'contact_info.add.*.is_primary' => ['required', 'boolean', new ValidatePrimaryContactRule(request()->input($group . 'contact_info.add') ?? [],[], $group)],
        ];

        return $rules;
    }

    private function extraRuleSetUpdate($group = ''): array
    {
        $rules = [
            'contact_info.update' => ['array'],
            'contact_info.update.*.id' => ['required', 'distinct', Rule::notIn(request()->input($group . 'contact_info.remove')), 'exists:contact_infos,id'],
            'contact_info.update.*.label' => ['required','string', new CaseInsensitiveRuleIn(['work', 'home', 'mobile', 'other'])],
            'contact_info.update.*.type' => ['required','string', new CaseInsensitiveRuleIn(['email', 'phone'])],
            // 'contact_info.update.*.value' => ['required_with:type', 'string', 'max:128'],
            'contact_info.update.*.value' => ['required_with:type', 'string', 'max:128', new ContactInfoDynamicRule(request()->input($group . 'contact_info.update.*.type'))],
            'contact_info.update.*.is_primary' => ['required', 'boolean', new ValidatePrimaryContactRule([],request()->input($group . 'contact_info.update') ?? [])],

            'contact_info.remove' => ['array'],
            'contact_info.remove.*' => ['integer', 'distinct', 'exists:contact_infos,id']
        ];

        return $rules;
    }

    public function emailArray($group = ''): array
    {
        $keys = [];
        $emails = request()->input($group . 'email') ?? [];
        foreach ($emails as $key => $email) {
            if (is_array($email)) {
                $keys['email.' . $key . '.label'] = ['string', 'in:home,work,other'];
                $keys['email.' . $key . '.value'] = ['email'];
            }
            if (is_string($email)) {
                $keys['email.' . $key] = ['email'];
            }
        }

        return array_merge([
            'email' => ['nullable', 'array'],
        ], $keys);
    }
}
