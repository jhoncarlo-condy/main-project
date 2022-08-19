<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Entities\ContactInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    const TYPE_EMAIL = 'email';
    const TYPE_PHONE = 'phone';

    protected $guarded = ['id'];

    public $relationships = ['contactInfos'];

    protected static function newFactory()
    {
        // return \Modules\Contact\Database\factories\ContactFactory::new();
    }

    public function contactInfos()
    {
        return $this->morphMany(ContactInfo::class, 'contact_infoable');
    }
}
