<?php

namespace App\Http\Controllers\Oficina;

use App\Oficina;
use App\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use UxWeb\SweetAlert\SweetAlert as Alert;
use App\Http\Controllers\Controller;
use App\Transaction;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OficinaController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                foreach (Auth::user()->perfil->componentes as $componente)
                    if ($componente->modulo->nombre == "oficinas")
                        return $next($request);
                return redirect()->route('denegado');
            } else
                return redirect()->route('login');
        });
    }

    private function hasComponent($nombre)
    {
        foreach (Auth::user()->perfil->componentes as $componente)
            if ($componente->nombre == $nombre)
                return true;
        return false;
    }

    public function index()
    {
        if ($this->hasComponent('indice oficinas')) {
            $oficinas = Oficina::get();
            return view('oficinas.index', ['oficinas' => $oficinas]);
        }
        return redirect()->route('denegado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->hasComponent('crear oficina')) {
            $estados = Estado::get();
            $ofi_id = DB::table('oficinas')->orderBy('id', 'desc')->first();
            // $ofi_id->id+1;
            return view('oficinas.create', ['estados' => $estados,'last_id'=>$ofi_id]);
        }
        return redirect()->route('denegado');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

         
        // $request->validate([
            
        //     'identificador'=>'required|integer',
        //     'nombre'=>'required|string',
        //     'calle'=>'required|string|min:2|max:100'
        //     'numext'=> 'required|integer',
        //     'cp'=> 'required|integer',
        //     'delegacion'=>'required|string|min:2|max:100',
        //     'ciudad'=>'required|string',
        //     'telefono1'=>'required|integer'
        // ]);

        $validator = Validator::make($request->all(), [
             'identificador' => 'required|unique:oficinas|max:99',
             'nombre'=>'required|string',
             'calle'=>'required|string|min:2|max:100',
             'numext'=> 'required|numeric',
             'cp'=> 'required|numeric',
             'delegacion'=>'required|string|min:2|max:100',
             'ciudad'=>'required|string',
             'colonia'=>'required|string',
             'telefono1'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }
        // dd($request->all());
        // dd($request->file('contrato_telefono'));
        $file_1 = $request->file('archivo_telefono');
        $name_1 = time().$file_1->getClientOriginalName();
        $file_1->move(public_path().'\contratos',$name_1);

        $file_2 = $request->file('archivo_agua');
        $name_2 = time().$file_2->getClientOriginalName();
        $file_2->move(public_path().'\contratos',$name_2);

        $file_3 = $request->file('archivo_luz');
        $name_3 = time().$file_3->getClientOriginalName();
        $file_3->move(public_path().'\contratos',$name_3);

        if ($this->hasComponent('crear oficina')) {
            $oficina = Oficina::create($request->all());
            $oficina->archivo_telefono = $name_1;
            $oficina->archivo_agua = $name_2;
            $oficina->archivo_luz = $name_3;
            $oficina->save();
            // $oficina->contrato_telefono = Storage::disk('local')->put('contrato_telefono', $request->contrato_telefono);
            // $oficina->contrato_luz = Storage::disk('local')->put('contrato_luz', $request->contrato_luz);

            // $oficina->contrato_agua = Storage::disk('local')->put('contrato_agua', $request->contrato_agua);
            
            return redirect()->route('oficinas.show', ['oficina' => $oficina]);
        }
        return redirect()->route('denegado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->hasComponent('ver oficina')) {
            $oficina = Oficina::find($id);
            return view('oficinas.view', ['oficina' => $oficina]);
        }
        return redirect()->route('denegado');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($this->hasComponent('editar oficina')) {
            $oficina = Oficina::find($id);
            $estados = Estado::get();
            return view('oficinas.edit', ['oficina' => $oficina, 'estados' => $estados]);
        }
        return redirect()->route('denegado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($this->hasComponent('editar oficina')) {
            $oficina = Oficina::find($id);
            $oficina->update($request->all());
            return redirect()->route('oficinas.show', ['oficina' => $oficina]);
        }
        return redirect()->route('denegado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         // dd("Estoy eliminando clientes");
          $oficina = Oficina::find($id);
          $oficina->delete();
         return redirect()->route('oficinas.index');

    }


   

    public function getCurrentFolio(Oficina $oficina){

        $transacciones = Transaction::where('oficina_id',$oficina->id)
                                ->whereIn('status', ['pagando', 'finalizado'])
                                ->whereYear('created_at', '=', date('Y'))
                                ->get();
                                
        $consecutivo = count($transacciones)+1;
        $consecutivo = sprintf('%03d', $consecutivo);
        $anio = date("y");

        $numFolio = $oficina->identificador . $consecutivo . $anio;
        return $numFolio;
    }
}
