<?php

namespace Modules\Contact\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidatePrimaryContactRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $group = '';
    protected array $contact_info_add_data    = [];
    protected array $contact_info_update_data = [];
    public function __construct($contact_info_add_data, $contact_info_update_data, string $group = '')
    {
        $this->contact_info_add_data    = $contact_info_add_data;
        $this->contact_info_update_data = $contact_info_update_data;
        $this->group = $group;
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
        // check if value == false
        // if(!$value) {
        //     return true;
        // }

        if(request()->method() === 'PUT'){
            if (request()->route('contact')) {
                $contact = request()->route('contact');
            } else if(request()->route('organization')) {
                $contact = request()->route('organization');
            }
            $contact_is_primary_count = $contact->contactInfos()->where('is_primary',true);
            $update_email_count = (clone $contact_is_primary_count)->where('type','email')->count();
            $update_phone_count = (clone $contact_is_primary_count)->where('type','phone')->count();

            //count of contact info "add" is_primary
            $contact_info_add_data = $this->contact_info_add_data;
            $add_email_data = 0;
            $add_phone_data = 0;
            if(count($contact_info_add_data) > 0){
                foreach($contact_info_add_data as $add_data){
                    if($add_data['type'] == 'email'){
                        if($add_data['is_primary']){
                            $add_email_data++;
                        }
                    }else{
                        if($add_data['is_primary']){
                            $add_phone_data++;
                        }
                    }
                }
            }

            //count of contact info "update" is_primary
            $update_email_data = 0;
            $update_phone_data = 0;
            $found_email = 0;
            $found_phone = 0;
            $contact_info_update_data = $this->contact_info_update_data;
            if(count($contact_info_update_data) > 0){
                foreach($contact_info_update_data as $update_data){
                    if($update_data['type'] == 'email'){
                        $find = $contact->contactInfos()->where('id',$update_data['id'])->where('is_primary',true)->where('type','email')->first();
                        if($find){
                            $found_email++;
                        }
                        if($update_data['is_primary']){
                            $update_email_data++;
                        }
                    }else{
                        $find = $contact->contactInfos()->where('id',$update_data['id'])->where('is_primary',true)->where('type','phone')->first();
                        if($find){
                            $found_phone++;
                        }
                        if($update_data['is_primary']){
                            $update_phone_data++;
                        }
                    }
                }
            }

            if($contact_info_update_data == [] && $contact_info_add_data == []){
                return true;
            }

            if($update_email_count && $add_email_data >=1){
                return false;
            }

            if($update_phone_count && $add_phone_data >=1){
                return false;
            }

            if($update_email_count && $update_email_data == 0 && $found_email >=1){
                return false;
            }

            if($update_email_count && $update_phone_data == 0 && $found_phone >=1){
                return false;
            }

            if($update_email_count && $update_email_data >= 1 && $found_email == 0){
                return false;
            }

            if($update_email_count && $update_phone_data >= 1 && $found_phone == 0){
                return false;
            }

        }

        $contact_infos = request()->input($this->group . 'contact_info.add');
        $contact_infos = collect($contact_infos);
        $contact_infos_update = request()->input($this->group . 'contact_info.update');

        $contact_infos_merge = $contact_infos->merge($contact_infos_update);

        $count = $contact_infos_merge->where('is_primary', true);

        $email_count = (clone $count)->where('type','email')->count();
        $phone_count = (clone $count)->where('type','phone')->count();

        if($email_count > 1 || $phone_count > 1){
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is invalid. Only 1 primary contact info is allowed.';
    }
}
