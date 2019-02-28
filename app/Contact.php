<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'surname', 'email', 'photo', 'favorite'];

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}
