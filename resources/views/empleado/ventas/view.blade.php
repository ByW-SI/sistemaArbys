@extends('layouts.blank')
@section('content')
	{{-- expr --}}
	
	<div class="container">
		<div class="panel panel-group">
			@include('empleado.head')
			<ul class="nav nav-tabs nav-justified">
				<li role="presentation" class=""><a href="{{ route('empleados.show',['empleado'=>$empleado]) }}"  class="ui-tabs-anchor">Generales:</a></li>
		
				<li role="presentation" ><a href="{{ route('empleados.laborals.index',['empleado'=>$empleado]) }}" class="ui-tabs-anchor">Laborales:</a></li>
				
				@if(count($empleado->laborales) > 0 && $empleado->laborales->last()->puesto->nombre == "Vendedor")
					<li role="presentation" class="active"><a href="{{ route('empleados.objetivos.index', ['empleado' => $empleado]) }}">Ventas:</a></li>
				@endif
		
				<li role="presentation" class=""><a href="{{ route('empleados.estudios.index',['empleado'=>$empleado]) }}" class="ui-tabs-anchor">Estudios:</a></li>
		
				<li role="presentation" class=""><a href="{{ route('empleados.emergencias.index',['empleado'=>$empleado]) }}" class="ui-tabs-anchor">Emergencias:</a></li>
		
				<li role="presentation" class=""><a href="{{ route('empleados.vacaciones.index',['empleado'=>$empleado]) }}" class="ui-tabs-anchor">Vacaciones:</a></li>
		
				<li role="presentation" class=""><a href="{{ route('empleados.faltas.index',['empleado'=>$empleado]) }}" class="ui-tabs-anchor">Administrativo:</a></li>
			</ul>
			<div class="panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-sm-4">
								<h3>Objetivos:</h3>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="form-group col-sm-3">
								<label class="control-label">Fecha:</label>
								<input class="form-control" type="date" name="fecha" id="fecha" value="{{ date("Y-m-d") }}" readonly="">
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">Objetivo prospectos:</label>
								<input class="form-control" type="number" name="num_clientes" id="num_clientes" value="60">
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">Objetivo venta:</label>
								<input class="form-control" type="number" name="venta" id="venta" value="6">
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-sm-12 text-center">
								@php
								$fecha = Carbon\Carbon::now();
								$fecha = explode("-", $fecha->format("Y-m-d"));
								$fecha = $fecha[0] . "-" . $fecha[1];
								@endphp
								@if($fecha != $fecha_ul_obje)
								<button class="btn btn-success" id="asignar">
									<i class="fa fa-pencil"></i><strong> Asignar</strong>
								</button>
								@else 
								<h4>Ya has asigando un objetivo este mes</h4>
								@endif
							</div>
						</div>
					</div>
				</div>
			<div class="panel-default">
				<div class="panel-heading"><h3><strong>Historial:</strong></h3></div>
				<div class="panel-body">
					<div class="col-sm-12" id="div-tabla">
					@if(count($objetivos) > 0)
		  				<table class="table table-bordered table-hover table-stripped">
		  					<thead>
		  						<tr class="info">
		  							<th class="col-sm-4">Fecha:</th>
		  							<th class="col-sm-4">Objetivo Prospectos:</th>
		  							<th class="col-sm-4">Objetivo Venta:</th>
		  						</tr>
		  					</thead>
	  						<tbody id="cuerpo">	
				  					<tr>
										<td>{{ $objetivos->last()->fecha}}</td>
				  						<td>{{ $objetivos->last()->num_clientes}}</td>
				  						<td>{{ number_format($objetivos->last()->ventas) }}</td>
				  					</tr>
				  					
								
							</tbody>
		  				</table>
		  			@else
		  			<h5>No hay objetivos asignados</h5>
		  			@endif
		  			</div>				
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
<script>
	$(document).ready(function($) {
		$('#asignar').on('click', function(event) {
			event.preventDefault();
			var vendedor = {{ $empleado->vendedor->id }};
			var objetivo_cliente = $('#num_clientes').val();
		    var objetivo_venta = $('#venta').val();
		    var fecha = $('#fecha').val();
		    var token = '{{csrf_token()}}';// ó $("#token").val() si lo tienes en una etiqueta html.
		    var data={objetivo_cliente:objetivo_cliente,_token:token, objetivo_venta:objetivo_venta, fecha:fecha, vendedor:vendedor};
			$.ajax({
				url : '{{ route('empleados.objetivos.store', ['empleado' => $empleado]) }}',
				type : "POST",
				dataType : "json",
				data : data,
			}).done(function (data) {				
				var contenido = '';
				$.each(data.objetivos, function( index, value ) {
				   contenido = `<tr><td>${value.fecha}</td><td>${value.num_clientes}</td><td>${value.ventas}</td></tr>`;
				});


				$('#div-tabla').empty()
				var tabla = `<table class="table table-bordered table-hover table-stripped">
		  					<thead>
		  						<tr class="info">
		  							<th class="col-sm-4">Fecha:</th>
		  							<th class="col-sm-4">Objetivo Prospectos:</th>
		  							<th class="col-sm-4">Objetivo Venta:</th>
		  						</tr>
		  					</thead>
	  						<tbody id="cuerpo">
	  						${contenido}
	  						</tbody>
		  				</table>
				`;
				$('#div-tabla').append(tabla);
			}).fail(function(data){
				console.log(data);
			});
		});
	});
</script>
@endsection