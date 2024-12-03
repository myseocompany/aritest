<?php

namespace App\Http\Controllers;

use App\Models\Subset;
use Illuminate\Http\Request;

class SubsetController extends Controller
{
    //
    public function index()
    {
        // Aquí va la lógica de obtener los subsets
        $subsets = Subset::all();
        return view('home', compact('subsets'));
    }
}
