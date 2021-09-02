<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'stocks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'team_id',
        'asset_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'current_stock',
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

    public function scopeSearch($query, $asset_id, $team_id)
    {
        $query->where('asset_id', '=', $asset_id);
        $query->where('team_id', '=', $team_id);
    }

    public function getProducts($assets)
    {
        $teams = Team::all();
        $products = [];
        foreach ($assets as $asset) {
            foreach ($teams as $team) {

                $products[$asset->id]['id'] = $asset['id'];
                $products[$asset->id]['name'] = $asset['name'];
                if($asset->unit){
                    $products[$asset->id]['unit'] = $asset['unit']->name;
                }

                $stock = Stock::search($asset['id'], $team['id'])->first();
                if($stock){
                    $products[$asset->id]['stock'][$team->id] = $stock['current_stock'];
                } else {
                    $products[$asset->id]['stock'][$team->id] = 0;
                }

            }
        }

        return $products;
    }

}
