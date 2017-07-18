<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contact;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'address1',
        'address2',
        'state',
        'city',
        'zip',
        'country',
    ];

    public function contact() {
        return $this->belongsTo('Contact');
    }
}
