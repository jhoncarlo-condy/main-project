<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactInfo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        // return \Modules\Contact\Database\factories\ContactInfoFactory::new();
    }

    public function contactInfoable()
    {
        return $this->morphTo();
    }
}
