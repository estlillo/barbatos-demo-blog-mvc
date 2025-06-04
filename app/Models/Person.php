<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    protected $table = 'persons';

    protected $fillable = [
        'user_id',
        'phone',
        'birth_date',
        'address',
        'gender',
        'nationality',
        'biography',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
