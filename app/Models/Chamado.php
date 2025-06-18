<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Equipe;


class Chamado extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Adicione 'user_id' aqui
        'titulo',
        'descricao',
        'prioridade',
        'status', // Se você permitir que o status seja definido na criação
        // Adicione outros campos que você permite mass assignment
        'equipe_id',
    ];

    // Defina os relacionamentos (se houver)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }
}