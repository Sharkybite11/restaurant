<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatterMenu extends Model
{
    use HasFactory;

    protected $table = 'platter_menu';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
} 