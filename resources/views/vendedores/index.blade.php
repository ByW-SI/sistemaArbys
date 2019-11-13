@extends('layouts.blank')
@section('content')

<div class="container">
	<div class="panel panel-group">
		<div class="panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-4">
						<h4>Vendedores:</h4>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12">
						@if(count($vendedores) > 0)
							<table id="vendedores" class="table table-striped table-bordered table-hover" style="margin-bottom: 0px">
								<thead>
									<tr class="info">
										<th>ID</th>
										<th>Nombre</th>
										<th>Apellido Paterno</th>
										<th>Apellido Materno</th>
										<th>RFC</th>
										<th>Estado</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
								@foreach($vendedores as $vendedor)
									<tr class="active">
										<td>{{ $vendedor->id }}</td>
										<td>{{ !$vendedor->empleado ?: $vendedor->empleado->nombre }}</td>
										<td>{{ !$vendedor->empleado ?: $vendedor->empleado->appaterno }}</td>
										<td>{{ !$vendedor->empleado ?: $vendedor->empleado->apmaterno }}</td>
										<td>{{ !$vendedor->empleado ?: $vendedor->empleado->rfc }}</td>
										<td>{{ $vendedor->status }}</td>
										<td class="text-center">
											@if (Auth::user()->id == 1 || Auth::user()->perfil->componentes()->where('nombre','ver empleado')->first())
												<a class="btn btn-primary btn-sm" href="{{ route('empleados.show', ['empleado' => $vendedor->empleado]) }}">
													<i class="fa fa-eye"></i> Ver
												</a>
											@endif
											@if($vendedor->status == 'Activo')
											@if (Auth::user()->id == 1 || Auth::user()->perfil->componentes()->where('nombre','eliminar empleado')->first())
												<a class="btn btn-warning btn-sm" href="{{ route('vendedors.baja', ['vendedor' => $vendedor]) }}">
													<i class="fa fa-level-down"></i> Baja
												</a>
											@endif
											@else
												<a class="btn btn-success btn-sm" href="{{ route('vendedors.alta', ['vendedor' => $vendedor]) }}">
													<i class="fa fa-level-up"></i> Alta
												</a>
												<form action="{{ route('vendedors.destroy', ['vendedor' => $vendedor]) }}" style="display: inline;" method="post">
													{{ csrf_field() }}
													<input type="hidden" name="_method" value="DELETE">
													<button type="submit" class="btn btn-danger btn-sm">
														<i class="fa fa-times"></i> Eliminar
													</button>
												</form>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						@else
							<h4>No hay vendedores disponibles.</h4>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
<script>
$(document).ready(function() {
    $('#vendedores').DataTable({
		'language':{
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}
	});
} );
</script>
@endsection