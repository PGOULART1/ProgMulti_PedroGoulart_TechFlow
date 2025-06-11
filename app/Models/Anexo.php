<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    use HasFactory;

    protected $fillable = [
        'chamado_id', // ID do chamado relacionado
        'nome', // Nome do arquivo anexado
        'caminho', // Caminho do arquivo no servidor
        'created_at', // Data de criação do anexo
        'updated_at', // Data de atualização do anexo
        
    ];
}
