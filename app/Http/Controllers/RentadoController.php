<?php

namespace App\Http\Controllers;

use App\Models\Rentado;
use App\Http\Requests\StoreRentadoRequest;
use App\Http\Requests\UpdateRentadoRequest;
use Illuminate\Http\Request;

class RentadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreRentadoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->only(['id_usuario', 'id_libro']);
        Rentado::create(
            $data
        );
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rentado  $rentado
     * @return \Illuminate\Http\Response
     */
    public function show(Rentado $rentado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rentado  $rentado
     * @return \Illuminate\Http\Response
     */
    public function edit(Rentado $rentado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRentadoRequest  $request
     * @param  \App\Models\Rentado  $rentado
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRentadoRequest $request, Rentado $rentado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rentado  $rentado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rentado $rentado)
    {
        $rentado->delete();
        return redirect()->back();
    }
}
