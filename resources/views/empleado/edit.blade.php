@extends('layouts.blank')
@section('content')

<div class="container">
	<div class="panel panel-group">
		<div class="panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-4">
						<h4>Datos del Empleado:</h4>
					</div>
					<div class="col-sm-4 text-center">
						<a href="{{ route('empleados.create') }}" class="btn btn-success">
							<i class="fa fa-plus"></i><strong> Agregar Empleado</strong>
						</a>
					</div>
					<div class="col-sm-4 text-center">
						<a href="{{ route('empleados.index') }}" class="btn btn-primary">
							<i class="fa fa-bars"></i><strong> Lista de Empleados</strong>
						</a>
					</div>
				</div>
			</div>
		</div>
		<form method="POST" action="{{ route('empleados.update', ['empleado' => $empleado]) }}">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">
			<div class="panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-sm-3">
							<label class="control-label" for="nombre">✱Nombre(s):</label>
							<input type="text" class="form-control" name="nombre" required="" value="{{ $empleado->nombre }}">
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label" for="appaterno">✱Apellido Paterno:</label>
							<input type="text" class="form-control" name="appaterno" required="" value="{{ $empleado->appaterno }}">
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label" for="apmaterno">Apellido Materno:</label>
							<input type="text" class="form-control" name="apmaterno" value="{{ $empleado->apmaterno }}">
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label" for="fnac">Fecha de nacimiento:</label>
							<input type="date" class="form-control" name="nacimiento" value="{{ $empleado->nacimiento }}">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-3">
							<label class="control-label" for="rfc">✱RFC:</label>
							<input type="text" class="form-control" name="rfc" value="{{ $empleado->rfc }}" required="">
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label" for="email">✱Correo electrónico:</label>
							<input type="text" class="form-control" name="email" value="{{ $empleado->email }}" required="">
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label" for="telefono">Teléfono:</label>
							<input type="text" class="form-control" name="telefono" value="{{ $empleado->telefono }}">
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label" for="movil">Celular:</label>
							<input type="text" class="form-control" name="movil" value="{{ $empleado->movil }}">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-3">
							<label class="control-label" for="nss">NSS (IMSS):</label>
							<input type="text" class="form-control" name="nss" value="{{ $empleado->nss }}">
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label" for="curp">CURP:</label>
							<input type="text" class="form-control" name="curp" value="{{ $empleado->curp }}">
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label" for="infonavit">INFONAVIT:</label>
							<input type="text" class="form-control" name="infonavit" value="{{ $empleado->infonavit }}">
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
		</div>
	</form>
</div>

@endsection