<?php

namespace Modules\Contact\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Queries\ContactIndexQuery;
use Modules\Contact\Actions\CreateContactAction;
use Modules\Contact\Transformers\ContactResource;
use Modules\Contact\Http\Requests\CreateContactRequest;
use Modules\Contact\DataTransferObjects\CreateContactData;

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
        CreateContactRequest $request,
        CreateContactAction $action
    )
    {
        $data = CreateContactData::fromCreateRequest($request);
        $result = $action($data);

        return response()->json(new ContactResource($result));
    }

    public function show(Contact $contact)
    {
        return response()->json(new ContactResource($contact));
    }

    public function update(Request $request, $id)
    {
        dd('update');
    }

    public function destroy($id)
    {
        return response()->json([
            'message' => 'delete'
        ]);
    }
}
