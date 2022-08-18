<?php

namespace Modules\ContactInfo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        // return \Modules\ContactInfo\Database\factories\ContactInfoFactory::new();
    }
}
