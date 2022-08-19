<?php
namespace Modules\Contact\DataTransferObjects;

use Modules\Contact\Http\Requests\CreateContactRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateContactData extends DataTransferObject
{
    public string $first_name;
    public string $last_name;
    public string $title;

    public static function fromCreateRequest(CreateContactRequest $request) : self
    {
        $data = $request->safe()->all();

        return new self([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'title'      => $data['title'],
        ]);
    }
}
