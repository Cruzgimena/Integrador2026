<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $table = 'lotes';
    protected $primaryKey = 'id_lote';

    protected $fillable = [
        'fecha_hora_entrada',
        'fecha_hora_salida',
        'peso_bruto',
        'tara',
        'peso_neto',
        'calidad',
        'id_proveedor',
        'patente',
        'id_usuario',
    ];
}