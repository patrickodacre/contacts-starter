<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Address;

class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'description',
        'category_id',
    ];

    public function addresses() {
        return $this->hasMany('Address');
    }
}
