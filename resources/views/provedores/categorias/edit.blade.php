@extends('layouts.blank') 
	@section('content')
	<div class="container">
		<form role="form" method="POST" action="{{ route('categoria.put') }}">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            <input name="categoria_id", type="hidden" value="{{$categoria->id}}">
			<div class="panel panel-default">
				<div class="panel-heading">
					Editar categoria &nbsp;&nbsp;&nbsp;&nbsp;  <i class="fa fa-asterisk" aria-hidden="true"></i>Campos Requeridos
				</div>
				<div class="panel-body">
					<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<label class="control-label" for="nombre"><i class="fa fa-asterisk" aria-hidden="true"></i> Nombre de la categoria:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{$categoria->nombre}}" required autofocus>
					</div>
				</div>
				<div class="panel-body">
					<button type="submit" class="btn btn-success">
					<strong>Guardar</strong>
				</button>
					
				</div>	
			</div>
		</form>
	</div>
	@endsection  