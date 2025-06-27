<?php

namespace App\Http\Controllers;

use App\Models\Anexo;
use Illuminate\Http\Request;

class AnexoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Anexo $anexo)
    {
        // === PONTO CRÍTICO: SEGURANÇA ===
        // Verifique se o usuário logado tem permissão para ver este anexo.
        // Ex: O anexo pertence a um chamado que o usuário pode ver?
        // if (auth()->user()->cannot('view', $anexo)) { // Se você usa Gates/Policies
        //     abort(403, 'Acesso negado.');
        // }
        // Ou, uma verificação mais simples se o anexo pertence a um chamado específico:
        // if ($anexo->chamado && $anexo->chamado->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Você não tem permissão para ver este anexo.');
        // }


        // Supondo que 'caminho' no seu Model Anexo armazena o caminho relativo dentro do storage
        // Ex: 'anexos/2025/06/nomehash.png'
        $filePath = $anexo->caminho; // Use a coluna 'caminho' do seu modelo

        // Se você salvou os arquivos no disco 'public' (storage/app/public)
        // e criou o link simbólico 'php artisan storage:link'
        $disk = 'public'; // Ou outro disco que você esteja usando

        if (!Storage::disk($disk)->exists($filePath)) {
            abort(404, 'Anexo não encontrado.');
        }

        $headers = [
            'Content-Type' => $anexo->tipo_mime, // Use a coluna 'tipo_mime' do seu modelo
            'Content-Disposition' => 'inline; filename="' . $anexo->nome_original . '"', // Use 'nome_original'
        ];

        return Storage::disk($disk)->response($filePath, $anexo->nome_original, $headers);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anexo $anexo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anexo $anexo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anexo $anexo)
    {
        //
    }
}
