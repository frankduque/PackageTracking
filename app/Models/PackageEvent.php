<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageEvent extends Model
{

    use HasFactory;

    protected $fillable = [
        'package_id',
        'data',
        'hora',
        'local',
        'status',
        'sub_status',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getSubStatusAttribute($value)
    {
        return json_decode($value);
    }
}
