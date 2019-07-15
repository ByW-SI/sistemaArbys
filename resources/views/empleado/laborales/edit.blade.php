@extends('layouts.blank')
@section('content')

<div class="container">
	<div class="panel panel-group">
		@include('empleado.head')
		<ul class="nav nav-tabs nav-justified">
			<li><a href="{{ route('empleados.show', ['empleado' => $empleado]) }}">Generales:</a></li>
			<li class="active"><a href="{{ route('empleados.laborals.index', ['empleado' => $empleado]) }}">Laborales:</a></li>
			<li><a href="{{ route('empleados.estudios.index', ['empleado' => $empleado]) }}">Estudios:</a></li>
			<li><a href="{{ route('empleados.emergencias.index', ['empleado' => $empleado]) }}">Emergencias:</a></li>
			<li><a href="{{ route('empleados.vacaciones.index', ['empleado' => $empleado]) }}">Vacaciones:</a></li>
			<li><a href="{{ route('empleados.faltas.index', ['empleado' => $empleado]) }}">Administrativo:</a></li>
		</ul>
		<div class="panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-4">
						<h5>Laborales:</h5>
					</div>
				</div>
			</div>
			<form role="form" method="POST" action="{{ route('empleados.laborals.update', ['empleado' => $empleado, 'laboral' => $datoslab]) }}">
				<input type="hidden" name="_method" value="PUT">
				{{ csrf_field() }}
				<div class="panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="form-group col-sm-3">
								<label class="control-label">Fecha de Contratación:</label>
								<input class="form-control" type="date" name="contratacion" readonly="" value="{{ $datoslab->contratacion }}">
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">✱Fecha de Actualización:</label>
								<input class="form-control" type="date" name="actualizacion" required="">
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">✱Tipo de Contrato:</label>
								<select type="select" class="form-control" name="contrato_id" required="">
									<option>Sin Definir</option>
									@foreach ($contratos as $contrato)
										<option value="{{ $contrato->id }}" {{ $datoslab->contrato->id == $contrato->id ? 'selected' : '' }}>{{ $contrato->nombre }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">✱Área:</label>
								<select type="select" class="form-control" name="area_id" required="">
									<option>Sin Definir</option>
									@foreach ($areas as $area)
										<option value="{{ $area->id }}" {{ $datoslab->area->id == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">Puesto Inicial:</label>
								<input class="form-control" type="text" name="original" readonly="" value="{{ $datoslab->original }}">
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">✱Puesto:</label>
								<select type="select" name="puesto_id" id="puesto_id" class="form-control" required="">
									<option value="">Sin Definir</option>
									@if(count($puestos) > 0)
									@foreach($puestos as $puesto)
										<option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>f
									@endforeach
									@else
										<option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
									@endif
								</select>
							</div>
							<div class="form-group col-sm-3" style="display: none;" id="region">
								<label class="control-label">Región:</label>
								<select class="form-control" id="regiones" name="region_id">
									<option>No Definido</option>
									@foreach($regiones as $region)
										<option value="{{ $region->id }}">{{ $region->nombre }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-sm-3" style="display: none;" id="estado">
								<label class="control-label">Estado:</label>
								<select class="form-control" id="estados">
								</select>
							</div>
							<div class="form-group col-sm-3" id="oficina" style="display: none;">
								<label class="control-label">Oficina:</label>
								<select class="form-control" id="oficinas">
								</select>
							</div>
							<div class="form-group col-sm-3" id="experto" style="display: none;">
								<label class="control-label">✱Experto en:</label>
								<select id="expertos" class="form-control">
									<option value="">Seleccionar</option>
									<option value="Autos" {{ $datoslab->empleado->vendedor ? ($datoslab->empleado->vendedor->experto == "Autos" ? 'selected' : '') : '' }}>Autos</option>
									<option value="Motos" {{ $datoslab->empleado->vendedor ? ($datoslab->empleado->vendedor->experto == "Motos" ? 'selected' : '') : '' }}>Motos</option>
									<option value="Casas" {{ $datoslab->empleado->vendedor ? ($datoslab->empleado->vendedor->experto == "Casas" ? 'selected' : '') : '' }}>Casas</option>
									<option value="Autos y Motos" {{ $datoslab->empleado->vendedor ? ($datoslab->empleado->vendedor->experto == "Autos y Motos" ? 'selected' : '') : '' }}>Autos y Motos</option>
									<option value="Autos y Casas" {{ $datoslab->empleado->vendedor ? ($datoslab->empleado->vendedor->experto == "Autos y Casas" ? 'selected' : '') : '' }}>Autos y Casas</option>
									<option value="Motos y Casas" {{ $datoslab->empleado->vendedor ? ($datoslab->empleado->vendedor->experto == "Motos y Casas" ? 'selected' : '') : '' }}>Motos y Casas</option>
									<option value="Autos, Motos y Casas" {{ $datoslab->empleado->vendedor ? ($datoslab->empleado->vendedor->experto == "Autos, Motos y Casas" ? 'selected' : '') : '' }}>Autos, Motos y Casas</option>
								</select>
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">✱Salario Nominal:</label>
								<input class="form-control" type="text" name="actual" required>
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">Salario Inicial:</label>
								<input class="form-control" type="text" name="inicial" readonly="" value="{{ $datoslab->inicial }}">
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-sm-4 col-sm-offset-4 text-center">
								<button type="submit" class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Guardar</button>
							</div>
							<div class="col-sm-4 text-right text-danger">
								<h5>✱Campos Requeridos</h5>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

    	$('#puesto_id').change(function() {

    		var val = parseInt(document.getElementById("puesto_id").value);
      		document.getElementById('region').style.display = 'none';
      		document.getElementById('estado').style.display = 'none';
      		document.getElementById('oficina').style.display = 'none';
      		document.getElementById('experto').style.display = 'none';
			$("#regiones").prop('name', '');
			$("#estados").prop('name', '');
			$("#oficinas").prop('name', '');
			$("#expertos").prop('name', '');
			$("#regiones").prop('required', false);
			$("#estados").prop('required', false);
			$("#oficinas").prop('required', false);
			$("#expertos").prop('required', false);

    		switch(val) {
    			case 3:
      				document.getElementById('region').style.display = 'block';
      				document.getElementById('experto').style.display = 'block';
      				$("#regiones").prop('name', 'region_id');
					$("#regiones").prop('required', true);
					$("#expertos").prop('name', 'experto');
    				break;
    			case 4:
      				document.getElementById('region').style.display = 'block';
      				document.getElementById('estado').style.display = 'block';
      				document.getElementById('experto').style.display = 'block';
					$("#estados").prop('name', 'estado_id');
					$("#estados").prop('required', true);
					$("#regiones").prop('required', true);
					$("#regiones").prop('name', 'region_id');
					$("#expertos").prop('name', 'experto');
    				break;
    			case 5:
      				document.getElementById('region').style.display = 'block';
      				document.getElementById('estado').style.display = 'block';
      				document.getElementById('oficina').style.display = 'block';
      				document.getElementById('experto').style.display = 'block';
					$("#oficinas").prop('name', 'oficina_id');
					$("#estados").prop('required', true);
					$("#regiones").prop('required', true);
					$("#regiones").prop('name', 'region_id');
					$("#oficinas").prop('required', true);
					$("#expertos").prop('name', 'experto');
    				break;
    			case 6:
      				document.getElementById('region').style.display = 'block';
      				document.getElementById('estado').style.display = 'block';
      				document.getElementById('oficina').style.display = 'block';
      				document.getElementById('experto').style.display = 'block';
					$("#oficinas").prop('name', 'oficina_id');
					$("#estados").prop('required', true);
					$("#regiones").prop('required', true);
					$("#regiones").prop('name', 'region_id');
					$("#oficinas").prop('required', true);
					$("#expertos").prop('name', 'experto');
    				break;
    			case 7:
      				document.getElementById('region').style.display = 'block';
      				document.getElementById('estado').style.display = 'block';
      				document.getElementById('oficina').style.display = 'block';
      				document.getElementById('experto').style.display = 'block';
					$("#oficinas").prop('name', 'oficina_id');
					$("#expertos").prop('name', 'experto');
					$("#estados").prop('required', true);
					$("#regiones").prop('required', true);
					$("#regiones").prop('name', 'region_id');
					$("#oficinas").prop('required', true);
					$("#expertos").prop('required', true);
    				break;
    		}

			$('#regiones').change(function() {
				var id = $('#regiones').val();
				$.ajax({
					url: "{{ url('/region2') }}/"+id,
					type: "GET",
					dataType: "html",
					success: function(res){
						$('#estados').html(res);
					},
					error: function (){
						$('#estados').html('');
					}
				});
			});

			$('#estados').change(function() {
				var id = $('#estados').val();
				$.ajax({
					url: "{{ url('/estado2') }}/"+id,
					type: "GET",
					dataType: "html",
					success: function(res){
						$('#oficinas').html(res);
					},
					error: function (){
						$('#oficinas').html('');
					}
				});
			});

			$('#oficinas').change(function() {
				var id = $('#oficinas').val();
				$.ajax({
					url: "{{ url('/oficina2') }}/"+id,
					type: "GET",
					dataType: "html",
					success: function(res){
						$('#grupos').html(res);
					},
					error: function (){
						$('#grupos').html('');
					}
				});
			});

    	});

    });

</script>

@endsection