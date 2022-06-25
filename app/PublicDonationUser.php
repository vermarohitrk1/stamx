<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicDonationUser extends Model
{
    protected $fillable = [
        'user_id',
        'stripe_customer',
        'fname',
        'lname',
        'email',
        'address',
        'state',
        'city',
        'zip',
        'country',
        'monthlygift',
        'donation_date',
        'details',

    ];
}
