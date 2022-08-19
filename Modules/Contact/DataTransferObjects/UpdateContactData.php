<?php
namespace Modules\Contact\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;
use Modules\Contact\Http\Requests\ContactFormRequest;

class UpdateContactData extends DataTransferObject
{
    public static function fromRequest(ContactFormRequest $request): self
    {
        return new self([
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'title' => $request->input('title'),
            'organization_id' => $request->input('organization_id'),
            'email' => $request->input('email'),
            'owner_id' => $request->input('owner_id'),
            'contact_info' => [
                'add' => self::addContactInfoRequest($request),
                'update' => self::updateContactInfoRequest($request),
                'remove' => $request->input('contact_info.remove')
            ]
        ]);
    }

    private static function addContactInfoRequest(ContactFormRequest $request){
        $add_contact_info = null;
        if ($request->has('contact_info.add')) {
            $add_contact_info = [];

            foreach ($request->input('contact_info.add') as $info) {
                $add_contact_info[] = ContactInfoData::fromRequest($info);
            }
        }

        return $add_contact_info;
    }

    private static function updateContactInfoRequest(ContactFormRequest $request){
        $update_contact_info = null;
        if ($request->has('contact_info.update')) {
            $update_contact_info = [];

            foreach ($request->input('contact_info.update') as $info) {
                $update_contact_info[] = ContactInfoData::fromRequest($info);
            }
        }

        return $update_contact_info;
    }
}

