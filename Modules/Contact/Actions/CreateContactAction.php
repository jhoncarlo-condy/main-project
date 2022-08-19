<?php
namespace Modules\Contact\Actions;

use Modules\Contact\Entities\Contact;
use Modules\Contact\DataTransferObjects\CreateContactData;

class CreateContactAction
{
    public function __invoke(CreateContactData $data)
    {
        $contact = Contact::create($data->toArray());

        return $contact;
    }
}
