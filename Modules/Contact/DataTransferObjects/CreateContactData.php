<?php
namespace Modules\Contact\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;
use Modules\Contact\Http\Requests\ContactFormRequest;

class CreateContactData extends DataTransferObject
{
    public string $first_name;
    public string $last_name;
    public string $title;
    public ?array $contact_info;


    public static function fromRequest(ContactFormRequest $request) : self
    {
        $data = $request->safe()->all();

        $add_contact_info = null;
        if ($data['contact_info']['add']) {
            $add_contact_info = [];

            foreach ($data['contact_info']['add'] as $info) {
                $add_contact_info[] = ContactInfoData::fromRequest($info);
            }
        }

        return new self([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'title'      => $data['title'],
            'contact_info' => [
                'add' => $add_contact_info
            ]
        ]);
    }
}
