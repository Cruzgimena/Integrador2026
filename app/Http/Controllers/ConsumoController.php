<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use Illuminate\Http\Request;

class ConsumoController extends Controller
{
    public function index()
    {
        $consumos = Consumo::all(); 
        return view('consumos.index', compact('consumos'));
    }

    public function create()
    {
        return view('consumos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
