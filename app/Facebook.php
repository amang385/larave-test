<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facebook extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'create_by','id');
    }
}
