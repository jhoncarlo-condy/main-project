<?php
namespace Modules\Contact\Actions;

use Modules\Contact\Entities\Contact;
use Modules\Contact\DataTransferObjects\CreateContactData;

class CreateContactAction
{
    public function __construct(
        // protected CreateContactInfoAction $contactInfoAction,
        // protected UpsertContactInfoAction $upsertContactInfoAction,
    ) {}

    public function __invoke(CreateContactData $data)
    {
        $contact = Contact::create($data->toArray());

        // ($this->upsertContactInfoAction)($data, $result);

        // if(isset($data->contact_info['add'])){
        //     foreach ($data->contact_info['add'] as  $contact_info) {
        //         ($this->contactInfoAction)($contact_info->toArray(), $result);
        //     }
        // }

        return $contact;
    }
}
