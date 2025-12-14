<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fallable = [
        'user_id',
        'phone',
        'address',
        'date_of_birth',
        'bio',
    ];
    protected $table = 'profiles';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
