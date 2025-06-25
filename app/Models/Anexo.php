<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    protected $fillable = ['chamado_id', 'arquivo'];

    public function chamado()
    {
        return $this->belongsTo(Chamado::class);
    }
}
