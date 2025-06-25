<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Equipe;


class Chamado extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'prioridade',
        'equipe_id',
        'status',
        'arquivo',
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
    public function mensagens()
    {
        return $this->hasMany(Mensagem::class)->latest();
    }

    public function anexos()
    {   
        return $this->hasMany(Anexo::class);
    }
}