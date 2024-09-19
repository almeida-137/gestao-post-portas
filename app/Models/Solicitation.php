<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitation extends Model
{
    use HasFactory;

    protected $table = 'solicitations';

    protected $fillable = [
        'loja',
        'dataDoPedido',
        'cliente',
        'montador',
        'status',
        'itens',
    ];

    protected $casts = [
        'itens' => 'array',
    ];
}
