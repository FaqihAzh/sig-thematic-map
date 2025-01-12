<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    use HasFactory;
    protected $table = 'regencies';
    protected $fillable = ['province_id', 'name', 'alt_name', 'latitude', 'longitude'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function geoData()
    {
        return $this->hasMany(GeoData::class);
    }
}
