<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = 'regencies';
    protected $fillable = ['regency_id', 'name', 'alt_name', 'latitude', 'longitude'];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }
}
