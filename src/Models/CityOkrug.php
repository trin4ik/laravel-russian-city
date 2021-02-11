<?php

namespace Trin4ik\RussianCity\Models;

use Illuminate\Database\Eloquent\Model;

class CityOkrug extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
