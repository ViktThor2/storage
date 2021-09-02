<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    public $table = 'transactions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'stock',
        'team_id',
        'user_id',
        'asset_id',
        'importer_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');

    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

    public function importer()
    {
        return $this->belongsTo(Importer::class);
    }

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    public function chair()
    {
        return $this->belongsTo(Chair::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function setData($request, $id)
    {
        $this->stock     = $request['stock'];
        $this->asset_id  = $id;
        $this->user_id   = auth()->user()->id;
    }

    public function setDataBetween($request, $asset_id, $team_id)
    {
        $this->stock     = $request['stock'];
        $this->asset_id  = $asset_id;
        $this->team_id   = $team_id;
        $this->user_id   = auth()->user()->id;
        $this->importer_id = $request['from_team'];
    }

    public function getCreatedAtAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;

    }

    public function setCreatedAtAtAttribute($value)
    {
        $this->attributes['created_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function scopeSearch($query, $data)
    {
        $query->where('name', 'LIKE', '%' . $data . '%');
    }

}
