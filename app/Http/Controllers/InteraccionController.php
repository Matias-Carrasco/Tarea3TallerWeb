<?php

namespace App\Http\Controllers;

use App\Models\Interaccion;
use App\Models\Perro;
use App\Http\Requests\StoreInteraccionRequest;
use App\Http\Requests\UpdateInteraccionRequest;

class InteraccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Interaccion::orderBy('created_at', 'asc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInteraccionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInteraccionRequest $request)
    {
        $this->validate($request, [
            'perro_interesado_id' => 'required',
            'perro_candidato_id' => 'required',
            'preferencia' => 'required'
        ]);

        
        $id_perros = Perro::all()->pluck('id')->toArray();
        $interesado = $request->input('perro_interesado_id');
        $candidato = $request->input('perro_candidato_id');
        $preferencia = $request->input('preferencia');
        $patron = "/^(?:R|A|r|a)$/";

        if(!(in_array($interesado, $id_perros))){
            return response()->json('El perro que se esta intentando ingresar no existe', status:400);
        }

        if(!(in_array($candidato, $id_perros))){
            return response()->json('El perro que se esta intentando ingresar no existe', status:400);
        }

        if($candidato == $interesado){
            return response()->json('No se permite ingresar el mismo perro como interesado y candidato', status:400);
        }

        if(preg_match($patron,$preferencia)!=1){
            return response()->json('La preferencia solo pude ser de tipo (A|R)', status:400);
        }

        $lista_interesados = Interaccion::where('perro_interesado_id',$interesado)->get();
        
        foreach ($lista_interesados as $inte) {
            if(($inte->perro_candidato_id) == $candidato && ($inte->perro_interesado_id) == $interesado){
                return response()->json('Ya existe la esta interaccion', status:400);  
            }
        }

        
        $interaccion = new Interaccion;
        $interaccion->perro_interesado_id = $interesado;
        $interaccion->perro_candidato_id = $candidato;
        $interaccion->preferencia = $candidato;
        $interaccion->save();
        return response()->json($interaccion, status:201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Interaccion  $interaccion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Interaccion::where('perro_interesado_id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Interaccion  $interaccion
     * @return \Illuminate\Http\Response
     */
    public function edit(Interaccion $interaccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInteraccionRequest  $request
     * @param  \App\Models\Interaccion  $interaccion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInteraccionRequest $request, $interesado)
    {

        $this->validate($request, [
            'perro_candidato_id' => 'required',
            'preferencia' => 'required'
        ]);

        $id_perros = Perro::all()->pluck('id')->toArray();
        $candidato = $request->input('perro_candidato_id');
        $preferencia = $request->input('preferencia');
        $patron = "/^(?:R|A|r|a)$/";

        if(!(in_array($interesado, $id_perros))){
            return response()->json('El perro que se esta intentando ingresar no existe', status:400);
        }

        if(!(in_array($candidato, $id_perros))){
            return response()->json('El perro que se esta intentando ingresar no existe', status:400);
        }

        if($candidato == $interesado){
            return response()->json('No se permite ingresar el mismo perro como interesado y candidato', status:400);
        }

        if(preg_match($patron,$preferencia)!=1){
            return response()->json('La preferencia solo pude ser de tipo (A|R)', status:400);
        }

        $lista_interesados = Interaccion::where('perro_interesado_id',$interesado)->get();
        
        foreach ($lista_interesados as $inte) {
            if(($inte->perro_candidato_id) == $candidato && ($inte->perro_interesado_id) == $interesado){
                if(($inte->preferencia) == $preferencia){
                    return response()->json('Ya existe la esta interaccion', status:400);
                }
            }
        }
        
        $interaccion = Interaccion::findorFail($interesado);
        $interaccion->perro_interesado_id = $interesado;
        $interaccion->perro_candidato_id = $candidato;
        $interaccion->preferencia = $preferencia;
        $interaccion->update();
        return response()->json($interaccion, status:201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Interaccion  $interaccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interaccion $interaccion)
    {
        $interaccion = Interaccion::findorFail($id);
        if($interaccion->delete()){
            return response()->json('interaccion eliminada correctamente', status:201);
        }
    }
}
