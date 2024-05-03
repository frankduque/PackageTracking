<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Package extends Model
{

    use HasFactory;
    protected $fillable = [
        'codigo',
        'host',
        'time',
        'quantidade',
        'ultimo',
    ];

    public function packageEvent()
    {
        return $this->hasMany(PackageEvent::class);
    }

    public function getUltimoAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y H:i') : null;
    }

    public function getLastEventAttribute()
    {
        $lastEvent = $this->packageEvent()->latest()->first();
        return $lastEvent ? $lastEvent->status : null;

    }
}
