<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Método para listar usuarios
    public function index()
    {
        // Obtiene los usuarios paginados (10 por página)
        $users = User::where('email', "like", "%uao.edu.co")
            ->withCount('exams') // Cuenta la cantidad de exámenes
            ->withAvg('exams', 'score') // Calcula el promedio de la columna 'score' en los exámenes
            ->paginate(20);
          
        // Retorna la vista con los datos de los usuarios
        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        // Obtiene el usuario con sus exámenes
        $user = User::with('exams')->findOrFail($id);

        return view('users.show', compact('user'));
    }
}
