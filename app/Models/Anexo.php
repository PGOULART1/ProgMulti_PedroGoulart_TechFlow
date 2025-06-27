<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    protected $fillable = [
        'chamado_id',
        'nome_arquivo_hash',
        'nome_original',
        'tipo_mime',
        'caminho',
        'tamanho'
    ];

    public function chamado()
    {
        return $this->belongsTo(Chamado::class);
    }
}
