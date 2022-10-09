<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "id",
        "name",
        "forecast",
        "temperature",
        "feels_like",
        "temp_min",
        "temp_max",
        "pressure",
        "humidity"
    ];
}
