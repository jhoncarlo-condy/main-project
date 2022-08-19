<?php

namespace Modules\Contact\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class ContactInfoData extends DataTransferObject
{
    public string $value;
    public string $type;
    public ?int $id;
    public ?string $label;
    public bool $is_primary;

    public static function fromRequest(array $request): self
    {
        return new self([
            'value'      => $request['value'],
            'type'       => strtolower($request['type']),
            'id'         => isset($request['id']) ? $request['id'] : null,
            'label'      => strtolower($request['label']),
            'is_primary' => strtolower($request['is_primary']),
        ]);
    }
}
