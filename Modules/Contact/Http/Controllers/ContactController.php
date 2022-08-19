<?php

namespace Modules\Contact\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Queries\ContactIndexQuery;
use Modules\Contact\Actions\CreateContactAction;
use Modules\Contact\Actions\UpdateContactAction;
use Modules\Contact\Transformers\ContactResource;
use Modules\Contact\Http\Requests\ContactFormRequest;
use Modules\Contact\DataTransferObjects\CreateContactData;
use Modules\Contact\DataTransferObjects\UpdateContactData;

class ContactController extends Controller
{

    public function index(ContactIndexQuery $request)
    {
        $per_page = request()->query('per_page') ? request()->query('per_page') : 10;

        $results = $request->simplePaginate($per_page);

        $results->data = ContactResource::collection($results);

        return response()->json($results);
    }

    public function store(
        ContactFormRequest $request,
        CreateContactAction $action
    )
    {
        $data = CreateContactData::fromRequest($request);
        $result = $action($data);

        return response()->json(new ContactResource($result));
    }

    public function show(Contact $contact)
    {
        return response()->json(new ContactResource($contact));
    }

    public function update(
        Contact $contact,
        ContactFormRequest $request,
        UpdateContactAction $action
    )
    {
        $data = UpdateContactData::fromRequest($request);
        $result = $action($contact,$data);
        return response()->json(new ContactResource($result));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json([
            'message' => 'Contact deleted successfully'
        ]);
    }
}
