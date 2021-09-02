<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    public function asset()
    {
        return $this->hasMany(Asset::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_sub_categories()
    {
        return $this->hasMany(SubSubCategory::class);
    }
}
