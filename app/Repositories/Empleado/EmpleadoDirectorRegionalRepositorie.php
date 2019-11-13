<?php

namespace App\Repositories\Empleado;

use App\Empleado;
use App\Laboral;
use App\User;
use App\Vendedor;

class EmpleadoDirectorRegionalRepositorie
{

    public function getVendedores($empleado)
    {
        $region = $empleado->laborales()->orderBy('id', 'desc')->first()->region()->first();
        $laborals = Laboral::where('region_id', $region->id)->get();
        $empleados_id = $laborals->pluck('empleado_id')->flatten();
        $vendedores = Vendedor::whereIn('empleado_id', $empleados_id)->with('clientes.crm')->get();
        return $vendedores;
    }

    public function getUsers($empleado){
        return User::get();
    }

    public function getEmpleados($empleado){
        return Empleado::get();
    }
}
