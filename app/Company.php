<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
