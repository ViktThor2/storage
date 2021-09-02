<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Team extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'teams';

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
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'team_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'team_id');
    }

    public function chairs()
    {
        return $this->hasMany(Chair::class);
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
