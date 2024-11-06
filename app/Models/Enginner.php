<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enginner extends Model
{
    use HasFactory;

    protected $table = 'enginners';

    protected $fillable = [
        'cliente',
        'dataEng',
        'dataPcp',
        'dataFinalizacao',
        'status',
        'itens',
    ];

    protected $casts = [
        'itens' => 'array',
    ];
}
