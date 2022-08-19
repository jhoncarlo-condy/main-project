<?php

namespace Modules\Contact\Queries;

use Illuminate\Http\Request;
use Modules\Contact\Entities\Contact;
use Spatie\QueryBuilder\QueryBuilder;

class ContactIndexQuery extends QueryBuilder
{
    public function __construct(Request $request) {
        $query = Contact::query()
            ->with(
                'contactInfos'
                // 'organization',
                // 'addresses',
                // 'attributeEntities'
            );

        parent::__construct($query, $request);
    }
}
