<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    use HasFactory;

    public function asset()
    {
        return $this->hasMany(Asset::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

}
