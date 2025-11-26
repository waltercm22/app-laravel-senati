<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //CRUD
    //LISTAR
    public function listarCategoria(){
        // $categorias = Categoria::all();
        $categorias = Categoria::orderBy('created_at','ASC')->get();

        return response()->json([
            'success' => true,
            'nombre' => 'Walter Molina',
            'data' => $categorias
        ]
        );
    }
    public function agregarCategoria(){
        
    }
    public function editarCategoria(){
        
    }
    public function eliminarCategoria(){
        
    }
}
