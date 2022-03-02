<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editorial;
use App\Http\Requests\EditorialRequest;

class EditorialController extends Controller
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
            $columns = ['id', 'nombre'];

            $editoriales = Editorial::ofSearch($request->input('query'))
                ->orderBy('nombre')
                ->paginate($request->input('per_page'), $columns);

            return response()->json($editoriales);
        }

        return view('editoriales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('editoriales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditorialRequest $request)
    {
        $data  = $request->validated();

        Editorial::create($data);
        return response()->json([
            'message' => 'Editorial creada correctamente'
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
        $editorial = Editorial::findOrFail($id);

        return response()->json($editorial);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('editoriales.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditorialRequest $request, $id)
    {
        $data = $request->validated();

        $editoriales = Editorial::findOrFail($id);
        $editoriales->fill($data);
        $editoriales->save();

        return response()->json([
            'message' => 'Editorial actualizada correctamente'
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
        $editorial = Editorial::findOrFail($id);
        $editorial->delete();

        return response()->json([
            'message' => 'Editorial eliminada correctamente'
        ]);
    }
}
