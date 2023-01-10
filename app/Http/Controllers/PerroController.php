<?php

namespace App\Http\Controllers;

use App\Models\Perro;
use App\Http\Requests\StorePerroRequest;
use App\Http\Requests\UpdatePerroRequest;

class PerroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Perro::orderBy('created_at', 'asc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePerroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerroRequest $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'foto_url' => 'required',
            'descripcion' => 'required'
        ]);
  
        $perro = new Perro;
        $perro->nombre = $request->input('nombre');
        $perro->foto_url = $request->input('foto_url');
        $perro->descripcion = $request->input('descripcion');
        $perro->save();
        return response()->json($perro, status:201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perro  $perro
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Perro::findorFail($id);
    }

    public function random()
    {
        $databaselength = count(Perro::orderBy('created_at', 'asc')->get());
        $rand = rand(2, $databaselength-1);
        return Perro::findorFail($rand);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perro  $perro
     * @return \Illuminate\Http\Response
     */
    public function edit(Perro $perro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePerroRequest  $request
     * @param  \App\Models\Perro  $perro
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerroRequest $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'foto_url' => 'required',
            'descripcion' => 'required'
        ]);
  
        $perro = Perro::findorFail($id);
        $perro->nombre = $request->input('nombre');
        $perro->foto_url = $request->input('foto_url');
        $perro->descripcion = $request->input('descripcion');
        $perro->save();
        return response()->json($perro, status:201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perro  $perro
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perro = Perro::findorFail($id);
        if($perro->delete()){
            return response()->json('Perro eliminado correctamente', status:201);
        }
    }
}
