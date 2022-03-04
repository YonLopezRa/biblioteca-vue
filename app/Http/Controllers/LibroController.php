<?php

namespace App\Http\Controllers;

use App\Models\libro;
use App\Models\Rentado;
use Illuminate\Http\Request;
use App\Http\Requests\StorelibroRequest;
use App\Http\Requests\UpdatelibroRequest;

class LibroController extends Controller
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
     * @param  \App\Http\Requests\StorelibroRequest  $request
     * @return \Illuminate\Http\Response
     */
    //StorelibroRequest
    public function store(Request $request)
    {
        $data = $request->only(['titulo', 'autor', 'editorial', 'descripcion']);
        libro::updateOrCreate(
            ['id' => $request['id']],
            $data
        );
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function show(libro $libro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function edit(libro $libro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelibroRequest  $request
     * @param  \App\Models\libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatelibroRequest $request, libro $libro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function destroy(libro $libro)
    {
        Rentado::where('id_libro', $libro->id)->delete();
        $libro->delete();
        return redirect()->back();
    }
}
