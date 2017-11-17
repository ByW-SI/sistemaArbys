<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Personal;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Personal $personal, Request $request)
    {
        $marcas = DB::select('select distinct marca from products');
        $tipos = DB::select('select distinct tipo from products');
        // dd($marcas[0]);
        if (count($request->all()) == 0) {
            # code...
            //
            // if ($personal->tipo == 'Cliente') {
            //     # code...
            $productos = Product::sortable()->paginate(10);
            return view('productos.index',['personal'=>$personal,'productos'=>$productos,'marcas'=>$marcas, 'tipos'=>$tipos]);
            // } else {
            //     # code...
            //     return redirect('personals');
            // }
        } else {
            # code...
            // dd($request->all());
            $precio1 = (int)$request->costo1;
            $precio2 = (int)$request->costo2;
            $mensual1 = $request->mensualidad1;
            $mensual2 = $request->mensualidad2;
            $marca = $request->marca;
            $tipo = $request->tipo;
            $productos = Product::sortable()->where(function($busqueda) use($precio1, $precio2, $mensual1, $mensual2,$marca,$tipo){
                if ($precio1 != null || $precio1 != 0) {
                    # code...
                    if ($precio2 != null || $precio2 <$precio1 || $precio2 != 0) {
                        # code...
                        $busqueda->whereBetween('precio_lista',[$precio1,$precio2]);
                    } else {
                        # code...
                        $busqueda->whereBetween('precio_lista',[$precio1,$precio1+1]);
                    }
                    
                } 
                
            })->paginate(50);
            return view('productos.index',['personal'=>$personal,'productos'=>$productos,'marcas'=>$marcas, 'tipos'=>$tipos]);
            // $productos = Product::sortable()->where(
            //     function($query) use())->get();

        }
        
        
        
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function show(Personal $personal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function edit(Personal $personal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personal $personal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personal $personal)
    {
        //
    }
}
