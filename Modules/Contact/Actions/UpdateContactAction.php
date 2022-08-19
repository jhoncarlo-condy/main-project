<?php
namespace Modules\Contact\Actions;

use Modules\Contact\Entities\Contact;

class updateContactAction
{

    public function __construct(
        // protected CreateContactInfoAction $addContactInfoAction,
        // protected UpdateContactInfoAction $updateContactInfoAction,
        // protected DeleteContactInfoAction $deleteContactInfoAction,
    ) {}

    public function __invoke(Contact $contact, $data): Contact
    {
        $contact->update(
            array_filter($data->toArray(), fn($data) => $data !== NULL)
        );

        if(isset($data->contact_info['add'])){
            foreach ($data->contact_info['add'] as  $contact_info) {
                ($this->addContactInfoAction)($contact_info->toArray(), $contact);
            }
        }

        if(isset($data->contact_info['update'])){
            foreach ($data->contact_info['update'] as  $contact_info) {
                ($this->updateContactInfoAction)($contact_info->toArray(), $contact);
            }
        }

        if(isset($data->contact_info['remove'])){
            ($this->deleteContactInfoAction)($data->contact_info['remove'], $contact);
        }

        return $contact;
    }
}
