<?php

namespace Trin4ik\RussianCity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'id',
        'name',
        'population',
        'started_at',
        'coordinate',
        'polygon',
        'gerb',
        'description'

    ];

    public function okrug()
    {
        return $this->belongsTo(CityOkrug::class);
    }

    public function region()
    {
        return $this->belongsTo(CityRegion::class);
    }
}
