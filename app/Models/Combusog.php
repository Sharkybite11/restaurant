<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combusog extends Model
{
    use HasFactory;

    protected $table = 'combusog';

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