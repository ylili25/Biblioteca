<?php

namespace App\Http\Controllers;

use App\Models\{User,Libro,Prestamo};
use Illuminate\Http\Request;
use App\Http\Requests\PrestamoRequest;
use Psy\VarDumper\PresenterAware;

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {

            $prestamos = Prestamo::ofSearch($request->input('query'))
                ->orderBy('user_id')
                ->with([
                    'user:id,name',
                    'libro:id,nombre'
                ])
                ->paginate($request->input('per_page'));

            return response()->json($prestamos);
        }

        return view('prestamos.index');
    }

    public function create()
    {
        return view('prestamos.create');
    }

    public function crearPrestamo(PrestamoRequest $request)
    {
        $data = $request->validated();

        $libro = Libro::find($data['libro_id']);
        $libro->update([
            'cantidad' => $libro->cantidad - 1
        ]);

        Prestamo::create([
            'user_id'  => $request->user()->id,
            'libro_id' => $data['libro_id'],
            'estado'   => $data['estado']
        ]);

        return response()->json([
            'message' => 'Prestamo agregado correctamente'
        ]);
    }

    public function prestamosPendientes(Request $request)
    {
        if ($request->wantsJson()) {
            $prestamos = Prestamo::where([
                ['user_id', $request->user()->id],
                ['estado', 'Entregado']
            ])
            ->with('libro.editorial')
            ->get();

            return response()->json($prestamos);
        }

        return view('prestamos.pendientes');
    }

    public function devolverPrestamo(Request $request)
    {
        $libro = Libro::find($request->libro_id);
        $libro->update([
            'cantidad' => $libro->cantidad + 1
        ]);

        $prestamo = Prestamo::find($request->id);
        $prestamo->update([
            'estado' => 'Devuelto'
        ]);

        return response()->json([
            'message' => 'Prestamo modificado correctamente'
        ]);

    }

    public function usuariosListado(Request $request)
    {
        $usuarios = User::where('id','!=', $request->user()->id)->get(['id','name']);

        return response()->json($usuarios);
    }

    public function librosListado()
    {
        $libros = Libro::with('editorial:id,nombre')->get();

        return response()->json($libros);
    }
}
