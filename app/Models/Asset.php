<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasUuids;
    protected $fillable = [
        'asset_code', 'name', 'category_id', 'location_id', 
        'purchase_price', 'purchase_date', 'useful_life_years', 'status'
    ];
}