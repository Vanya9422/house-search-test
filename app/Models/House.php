<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [ // Указываем, какие поля разрешено заполнять массово
        'name',
        'bedrooms',
        'bathrooms',
        'storeys',
        'garages',
        'price',
    ];
}
