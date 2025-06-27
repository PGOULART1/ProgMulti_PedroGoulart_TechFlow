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
    public function user() { return $this->belongsTo(\App\Models\User::class); }

    public function equipe() { return $this->belongsTo(\App\Models\Equipe::class); }

    public function mensagens() { return $this->hasMany(\App\Models\Mensagem::class)->latest(); }

    public function anexos() { return $this->hasMany(\App\Models\Anexo::class); }
}