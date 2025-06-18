<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chamado;

class Equipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    /**
     * Uma equipe pode ter vários chamados.
     */
    public function chamados()
    {
        return $this->hasMany(Chamado::class);
    }
}
