@extends('layouts.blank')
@section('content')

<div class="container">
	<div class="panel panel-group">
		<div class="panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-4">
						<h4>Datos de la Oficina:</h4>
					</div>
                    @foreach(Auth::user()->perfil->componentes as $componente)
	                    @if($componente->nombre == 'indice oficinas')
							<div class="col-sm-4 text-center">
								<a href="{{ route('oficinas.index') }}"><button class="btn btn-primary"><strong><i class="fa fa-eye" aria-hidden="true"></i> Ver Oficinas</strong></button></a>
							</div>
						@endif
					@endforeach
				</div>
			</div>
			<form method="post" action="{{ route('oficinas.update', ['id' => $oficina->id]) }}">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-4">
							<div class="row">
								<div class="form-group col-sm-12">
									<label for="nombre" class="control-label">Nombre:</label>
									<input type="text" name="nombre" class="form-control" id="nombre" value="{{ $oficina->nombre }}">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-3">
									<label for="identificador" class="control-label">identificador:</label>
									<input type="text" name="identificador" maxlength="3" class="form-control" id="identificador" value="{{ $oficina->identificador }}" @if (!empty($oficina->identificador)) readonly @endif>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							{{-- <div class="row">
								<div class="form-group col-sm-12">
									<label for="responsable" class="control-label">Responsable:</label>
									<input type="text" name="responsable" class="form-control" id="responsable" value="{{ $oficina->responsable }}">
								</div>
							</div> --}}
							<div class="row">
								<div class="form-group col-sm-12">
									<label for="estado" class="control-label">Estado al que pertenece:</label>
									<select class="form-control" name="estado_id" id="estado">
										<option value="0">Seleccionar</option>
										@foreach($estados as $estado)
											<option value="{{ $estado->id }}" {{ $estado->id == $oficina->estado_id ? 'selected' : '' }}>{{ $estado->nombre }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="row">
								<div class="form-group col-sm-12">
									<label for="descripcion" class="control-label">Descripción:</label>
									<textarea class="form-control" maxlength="500" rows="4" name="descripcion" id="descripcion">{{ $oficina->descripcion }}</textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-default">
					<div class="panel-heading">
						<h4>Dirección:</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="form-group col-sm-3">
								<label for="calle" class="control-label">Calle:</label>
								<input type="text" class="form-control" id="calle" name="calle" value="{{ $oficina->calle }}">
							</div>
							<div class="form-group col-sm-3">
								<label for="numext" class="control-label">Número Exterior:</label>
								<input type="text" class="form-control" id="numext" name="numext" value="{{ $oficina->numext }}">
							</div>
							<div class="form-group col-sm-3">
								<label for="numint" class="control-label">Número Interior:</label>
								<input type="text" class="form-control" id="numint" name="numint" value="{{ $oficina->numint }}">
							</div>
							<div class="form-group col-sm-3">
								<label for="colonia" class="control-label">Colonia:</label>
								<input type="text" class="form-control" id="colonia" name="colonia" value="{{ $oficina->colonia }}">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-3">
								<label for="cp" class="control-label">CP:</label>
								<input type="text" class="form-control" id="cp" name="cp" value="{{ $oficina->cp }}">
							</div>
							<div class="form-group col-sm-3">
								<label for="delegacion" class="control-label">Delegación:</label>
								<input type="text" class="form-control" id="delegacion" name="delegacion" value="{{ $oficina->delegacion }}">
							</div>
							<div class="form-group col-sm-3">
								<label for="ciudad" class="control-label">Ciudad:</label>
								<input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ $oficina->ciudad }}">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 col-sm-offset-4 text-center">
								<button type="submit" class="btn btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Guardar</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection