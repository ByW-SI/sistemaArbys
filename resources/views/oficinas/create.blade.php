@extends('layouts.blank')
@section('content')

<div class="container">

		@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

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
			<form action="{{ route('oficinas.store') }}" method="post">
				{{ csrf_field() }}
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-sm-4">
							<label class="control-label">✱Nombre:</label>
							<input type="text" name="nombre" class="form-control" required="" value="{{old('nombre')}}">
							<span class="help-block">{{$errors->first('nombre')}} </span>
						</div>
						<div class="form-group col-sm-4">
							<label class="control-label">✱Estado al que pertenece:</label>
							<select class="form-control" name="estado_id" required=""  value="{{old('estado_id')}}">
								<option selected="selected" value="">Seleccionar</option>
								@foreach($estados as $estado)
									<option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errors->first('estado_id')}} </span>
						</div>
						<div class="form-group col-sm-1">
							<label class="control-label">✱identificador:</label>
							<input type="number" id="identificador" name="identificador" min="0" max="99" class="form-control" required  onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" value="{{old('identificador')}}">
							<span class="help-block">{{$errors->first('identificador')}} </span>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-4">
							<label class="control-label">Responsable Comercial:</label>
							<input type="text" name="responsable_com" class="form-control" readonly="">
						</div>
						<div class="form-group col-sm-4">
							<label class="control-label">Responsable Administrativo:</label>
							<input type="text" name="responsable_adm" class="form-control" readonly="">
						</div>
						<div class="col-sm-4">
							<label class="control-label">Descripción:</label>
							<textarea class="form-control" maxlength="500" rows="3" name="descripcion" value="{{old('descripcion')}}"></textarea>
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
								<label class="control-label">✱Calle:</label>
								<input type="text" class="form-control" name="calle" required="" value="{{old('calle')}}">
								<span class="help-block">{{$errors->first('calle')}} </span>
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">✱Número Exterior:</label>
								<input type="maxlength" class="form-control" name="numext" required="" value="{{old('numext')}}">
								<span class="help-block">{{$errors->first('numext')}} </span>
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">Número Interior:</label>
								<input type="text" class="form-control" name="numint" value="{{old('numint')}}">
								<span class="help-block">{{$errors->first('numint')}} </span>
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">✱Colonia:</label>
								<input type="text" class="form-control" name="colonia" required="" value="{{old('colonia')}}">
								<span class="help-block">{{$errors->first('colonia')}} </span>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-3">
								<label class="control-label">✱CP:</label>
								<input type="text" class="form-control" maxlength="5" name="cp" required="" value="{{old('cp')}}">
								<span class="help-block">{{$errors->first('cp')}} </span>
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">✱Delegación:</label>
								<input type="text" class="form-control" name="delegacion" required="" value="{{old('delegacion')}}">
								<span class="help-block">{{$errors->first('delegacion')}} </span>
							</div>
							<div class="form-group col-sm-3">
								<label class="control-label">✱Ciudad:</label>
								<input type="text" class="form-control" name="ciudad" required="" value="{{old('ciudad')}}">
								<span class="help-block">{{$errors->first('ciudad')}} </span>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<label class="control-label">✱Teléfono 1:</label>
								<input type="text" class="form-control" maxlength="10" name="telefono1" required="" value="{{old('telefono1')}}">
								<span class="help-block">{{$errors->first('telefono1')}} </span>
							</div>
							<div class="col-sm-3">
								<label class="control-label">Teléfono 2:</label>
								<input type="text" class="form-control" maxlength="10" name="telefono2" value="{{old('telefono2')}}">
							</div>
							<div class="col-sm-3">
								<label class="control-label">Teléfono 3:</label>
								<input type="text" class="form-control" maxlength="10" name="telefono3" value="{{old('telefono3')}}">
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

@endsection