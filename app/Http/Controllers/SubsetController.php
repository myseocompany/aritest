<?php

namespace App\Http\Controllers;

use App\Models\Subset;
use Illuminate\Http\Request;

class SubsetController extends Controller
{
    /**
     * Método original para la página principal.
     */
    public function index()
    {
        // Obtenemos los subsets existentes y los pasamos a la vista home
        $subsets = Subset::all();
        return view('home', compact('subsets'));
    }

    /**
     * Lista de subsets para el reporte.
     */
    public function list()
    {
        // Obtenemos los subsets con el conteo de preguntas
        $subsets = Subset::withCount('questions')->get();
        return view('subsets.index', compact('subsets'));
    }

    /**
     * Detalle de un subset con los exámenes relacionados.
     */
    public function show(Subset $subset)
    {
        // Obtenemos los exámenes del subset junto con los usuarios
        $exams = $subset->exams()->with('user')->get();
        return view('subsets.show', compact('subset', 'exams'));
    }
}
