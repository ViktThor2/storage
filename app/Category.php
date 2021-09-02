<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function asset()
    {
        return $this->hasMany(Asset::class);
    }

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }

}
