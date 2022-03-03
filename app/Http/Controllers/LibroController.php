<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Http\Requests\LibroRequest;

class LibroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->wantsJson()) {
            $columns = ['id', 'nombre', 'autor', 'isbn', 'cantidad', 'fecha_publicacion','editorial_id'];

            $libros = Libro::ofSearch($request->input('query'))
                ->orderBy('nombre')
                ->with('editorial:id,nombre')
                ->paginate($request->input('per_page'), $columns);

            return response()->json($libros);
        }

        return view('libros.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('libros.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LibroRequest $request)
    {
        $data  = $request->validated();


        $libros = Libro::create($data);
        return response()->json([
            'message' => 'Libro creado correctamente'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $libro = Libro::findOrFail($id);

        return response()->json($libro);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('libros.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LibroRequest $request, $id)
    {
        $data = $request->validated();

        $libros = Libro::findOrFail($id);
        $libros->fill($data);
        $libros->save();

        return response()->json([
            'message' => 'Libro actualizada correctamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $libros = Libro::findOrFail($id);
        $libros->delete();

        return response()->json([
            'message' => 'Libro eliminado correctamente'
            ]);
    }
}
