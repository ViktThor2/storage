<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Asset extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'assets';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'danger_level',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function sub_sub_category()
    {
        return $this->belongsTo(SubSubCategory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'asset_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'asset_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function setData($request)
    {
        $this->name = $request['name'];
        $this->description = $request['description'];
        $this->value = $request['value'];
        $this->critical_stock = $request['critical_stock'];
        $this->unit_id =  $request['unit_id'];
    }

    public function setCategory($request)
    {
        if($request->subsubcategory){
            $subsubcategory = SubSubCategory::find($request->subsubcategory);
            $this->sub_sub_category_id = $subsubcategory->id;
            $this->sub_category_id = $subsubcategory->sub_category->id;
            $this->category_id = $subsubcategory->sub_category->category->id;
        } elseif($request->subcategory) {
            $subcategory = SubCategory::find($request->subcategory);
            $this->sub_category_id = $subcategory->id;
            $this->category_id = $subcategory->category->id;
        } else {
            $this->category_id = $request->category;
        }
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeSearch($query, $data)
    {
        $query->where('name', 'LIKE', '%' . $data . '%');
    }

}

