@extends('layouts.blank')
@section('content')

<div class="panel panel-group" style="margin-bottom: 0px;">
	<div class="panel-default">
		<div class="panel-heading">
			<form id="search-form" action="{{ route('clientes.producto.index',['cliente'=>$cliente]) }}">
				<div class="row form-group">
					<div class="col-sm-4 text-center">
						<div class="input-group">
							<input type="number" id="min" name="min" value="{{$request->min}}" class="form-control"
								placeholder="Precio Mínimo" min="0" style="width: 153px">
							<input type="number" id="max" name="max" value="{{$request->max}}" class="form-control"
								placeholder="Precio Máximo" style="width: 152px">
						</div>
					</div>
					<div class="col-sm-4 text-center">
						<input type="text" id="producto" name="kword" value="{{$request->kword}}" class="form-control"
							placeholder="Buscar..." autofocus>
					</div>
					@if(isset($experto))
					@if($experto == "Autos" || $experto == "Autos y Motos" || $experto == "Autos, Motos y Casas")
					<div class="col-sm-2 text-center">
						<label class="control-label">Carros:</label>
						<div class="row">
							<input type="radio" name="type" id="carro" value="CARRO" @if ($request->type == "CARRO")
							checked
							@endif>
						</div>
					</div>
					@endif
					@if($experto == "Motos" || $experto == "Autos y Motos" || $experto == "Autos, Motos y Casas")
					<div class="col-sm-2 text-center">
						<label class="control-label">Motos:</label>
						<div class="row">
							<input type="radio" name="type" id="moto" value="MOTO" @if ($request->type == "MOTO")
							checked
							@endif>
						</div>
					</div>
					@endif
					@elseif(Auth::user()->empleado->id == 1)
					<div class="col-sm-2 text-center">
						<label class="control-label">Carros:</label>
						<div class="row">
							<input type="radio" @if ($request->type == "CARRO")
							checked
							@endif name="type" id="carro" value="CARRO">
						</div>
					</div>
					<div class="col-sm-2 text-center">
						<label class="control-label">Motos:</label>
						<div class="row">
							<input type="radio" name="type" id="moto" value="MOTO">
						</div>
					</div>
					@endif
				</div>
				
				<div class="row form-group" id="filtro-carro" style="display: none">
					<div class="col-sm-3 ">
						<label class="control-label">CATEGORIA</label>
						<select name="categoria" class="form-control">
							<option value="{{null}}">Seleccionar</option>
							@foreach ($categoriasCarros as $categoriaCarro)
							<option value="{{$categoriaCarro->id}}" {{ $request->categoria == $categoriaCarro->id ? 'selected' : '' }}>{{$categoriaCarro->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row form-group" id="filtro-moto" style="display: none">
					<div class="col-sm-3 ">
						<label class="control-label">De:</label>
						<select name="cilindrada_minima" class="form-control" id="cilindrada_minima">
							<option value="">Seleccionar</option>
							<option value="0cc" {{$request->cilindrada_minima == "0cc" ? 'selected' : ''}}>0 CC</option>
							<option value="100cc" {{$request->cilindrada_minima == "100cc" ? 'selected' : ''}}>100 CC</option>
							<option value="200cc" {{$request->cilindrada_minima == "200cc" ? 'selected' : ''}}>200 CC</option>
							<option value="300cc" {{$request->cilindrada_minima == "300cc" ? 'selected' : ''}}>300 CC</option>
							<option value="400cc" {{$request->cilindrada_minima == "400cc" ? 'selected' : ''}}>400 CC</option>
							<option value="500cc" {{$request->cilindrada_minima == "500cc" ? 'selected' : ''}}>500 CC</option>
							<option value="600cc" {{$request->cilindrada_minima == "600cc" ? 'selected' : ''}}>600 CC</option>
							<option value="700cc" {{$request->cilindrada_minima == "700cc" ? 'selected' : ''}}>700 CC</option>
							<option value="800cc" {{$request->cilindrada_minima == "800cc" ? 'selected' : ''}}>800 CC</option>
							<option value="900cc" {{$request->cilindrada_minima == "900cc" ? 'selected' : ''}}>900 CC</option>
							<option value="1000cc" {{$request->cilindrada_minima == "1000cc" ? 'selected' : ''}}>1000 CC</option>
						</select>
					</div>
					<div class="col-sm-3">
						<label class="control-label">A:</label>
						<select name="cilindrada_maxima" class="form-control" id="cilindrada_maxima">
							<option value="">Seleccionar</option>
						</select>
					</div>
					{{-- Tipos de moto --}}
					<div class="col-sm-3">
						<label class="control-label">Categoria:</label>
						<select name="tipo_moto_id" class="form-control">
							<option value="">Seleccionar</option>
							@foreach ($categoriasMotos as $categoriaMoto)
							<option value="{{$categoriaMoto->id}}" {{$request->tipo_moto_id == $categoriaMoto->id ? 'selected': ''}}>{{$categoriaMoto->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-12 text-center">
						<button type="submit" class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i>
							Buscar</button>
					</div>
				</div>
			</form>
		</div>
		<div id="productos">
			<div class="panel-body">
				<div class="col-sm-12">
					<table class="table table-striped table-bordered table-hover" style="margin-bottom: 0px">
						<tr class="info">
							<th class="col-sm-1">Identificador</th>
							<th class="col-sm-1">Categoria</th>
							<th class="col-sm-1">Marca</th>
							<th class="col-sm-4">Descripción</th>
							<th class="col-sm-2">Precio de Lista</th>
							<th class="col-sm-2">Precio de Apertura</th>
							<th class="col-sm-1">Acción</th>
						</tr>
						@if (isset($request) && count($productos) == 0)
						{{-- expr --}}
						<div class="alert alert-danger" role="alert">
							La busqueda no dio resultado
						</div>
						@endif
						@foreach($productos as $product)
						
						<tr class="active">
							<td>{{ $product->clave }}</td>
							<td>{{ $product->categoria }}</td>
							<td>{{ $product->marca }}</td>
							<td>{{ $product->descripcion }}</td>
							<td>${{ number_format($product->precio_lista, 2) }}</td>
							<td>${{ number_format($product->apertura, 2) }}</td>
							<td class="text-center">
								<a class="btn btn-primary btn-sm" data-toggle="modal"
									data-target="#myModal{{ $product->id }}"><i class="fa fa-eye"
										aria-hidden="true"></i> Ver</a>
							</td>
						</tr>
						
						@endforeach
					</table>
				</div>
			</div>
			<div class="panel-heading">
				{{ $productos->links() }}
			</div>
		</div>
	</div>
</div>

@foreach($productos as $producto)
<div class="modal fade" id="myModal{{ $producto->id }}" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-12">
						<h4 class="modal-title"><strong>Datos del Producto</strong></h4>
					</div>
				</div>
			</div>
			<div class="modal-body">
				@if(isset($producto))
				<div class="row">
					<div class="form-group col-sm-2 col-sm-offset-1">
						<label class="control-label">Clave:</label>
						<dd>{{ $producto->clave }}</dd>
					</div>
					<div class="form-group col-sm-2">
						<label class="control-label">Marca:</label>
						<dd>{{ $producto->marca }}</dd>
					</div>
					<div class="form-group col-sm-2">
						<label class="control-label">Descripción:</label>
						<dd>{{ $producto->descripcion }}</dd>
					</div>
					<div class="form-group col-sm-2">
						<label class="control-label">Precio de Lista:</label>
						<dd>${{ number_format($producto->precio_lista, 2) }}</dd>
					</div>
					<div class="form-group col-sm-2">
						<label class="control-label">Apertura:</label>
						<dd>${{ number_format($producto->apertura, 2) }}</dd>
					</div>
				</div>


				<form id="meses_{{$producto->id}}" method="GET"
					action="{{ route('clientes.producto.show', ['cliente' => $cliente, 'producto' => $producto]) }}">
					<div class="row">
						<div class="form-group col-sm-2 col-sm-offset-1">
							<div class="input-group">
								<span class="input-group-addon">
									<input type="checkbox"  id="m60" name="60 meses" aria-label="60 meses"
										{{ $producto['m60'] > 0 ? '' : 'disabled' }}>
									<label class="control-label">60 Meses:</label>
									<dd>{{ $producto['m60'] > 0 ? '$' . number_format($producto['m60'], 2) : 'N/A' }}
									</dd>
								</span>
							</div>
						</div>
						<div class="form-group col-sm-2">
							<div class="input-group">
								<span class="input-group-addon">
									<input type="checkbox" id="m48" name="48 meses" aria-label="48 meses"
										{{ $producto['m48'] > 0 ? '' : 'disabled' }}>
									<label class="control-label">48 Meses:</label>
									<dd>{{ $producto['m48'] > 0 ? '$' . number_format($producto['m48'], 2) : 'N/A' }}
									</dd>
								</span>
							</div>
						</div>
						<div class="form-group col-sm-2">
							<div class="input-group">
								<span class="input-group-addon">
									<input type="checkbox" id="m36" name="36 meses" aria-label="36 meses"
										{{ $producto['m36'] > 0 ? '' : 'disabled' }}>
									<label class="control-label">36 Meses:</label>
									<dd>{{ $producto['m36'] > 0 ? '$' . number_format($producto['m36'], 2) : 'N/A' }}
									</dd>
								</span>
							</div>
						</div>
						<div class="form-group col-sm-2">
							<div class="input-group">
								<span class="input-group-addon">
									<input type="checkbox" id="m24" name="24 meses" aria-label="24 meses"
										{{ $producto['m24'] > 0 ? '' : 'disabled' }}>
									<label class="control-label">24 Meses:</label>
									<dd>{{ $producto['m24'] > 0 ? '$' . number_format($producto['m24'], 2) : 'N/A' }}
									</dd>
								</span>
							</div>
						</div>
						<div class="form-group col-sm-2">
							<div class="input-group">
								<span class="input-group-addon">
									<input type="checkbox" id="m12" name="12 meses" aria-label="12 meses"
										{{ $producto['m12'] > 0 ? '' : 'disabled' }}>
									<label class="control-label">12 Meses:</label>
									<dd>{{ $producto['m12'] > 0 ? '$' . number_format($producto['m12'], 2) : 'N/A' }}
									</dd>
								</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<label class="radio-inline"><input type="radio" name="tipo_mensaje" class="standard"
									value="standard" checked>Mensaje standard</label>
							<label class="radio-inline"><input type="radio" name="tipo_mensaje" class="personalizado"
									value="personalizado">Mensaje personalizado</label>
						</div>
						<div class="col-sm-6 col-sm-offset-3 text-center">
							<textarea name="mensaje" maxlength="500" class="form-control mensaje"
								style="display:none"></textarea>
						</div>
					</div>
					<input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
					<input type="hidden" name="product_id" value="{{ $producto->id }}">
					<input type="hidden" name="mensaje_correo" class="mensaje_correo">
					<input class="btn btn-success" type="submit" id="correo" value="Enviar a Correo" name="correo" >
				</form>
				@endif
			</div>
			<div class="modal-footer">
				<div class="row text-center">
					{{-- <div class="col-sm-4">
						<form role="form" id="form-cliente" method="POST" action="{{ route('enviarCorreo', ['cliente' => $cliente,'producto' => $producto]) }}">
					{{ csrf_field() }}
					<input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
					<input type="hidden" name="product_id" value="{{ $producto->id }}">
					<input type="hidden" name="mensaje_correo" class="mensaje_correo">
					<input form="meses_{{$producto->id}}" class="btn btn-success" type="submit" value="Enviar a Correo">

					</form>
				</div> --}}
				<div class="col-sm-4">
					<button form="meses_{{$producto->id}}" id="pdf" name="pdf" type="submit" class="btn btn-warning" >Descargar PDF</button>
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endforeach
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
	function showFiltrosCarro(){
			$('#filtro-moto').prop('style', 'display: none;');
			$('#filtro-carro').prop('style', '');
		}

		function showFiltrosMoto(){
			$('#filtro-moto').prop('style', '');
			$('#filtro-carro').prop('style', 'display: none;');
		}

		/**
		 * Si se selecciona "carro" 
		 * se muestran los filtros de carro
		 * se ocultan los filtros de moto 
		*/
		// $('input[type=checkbox][id=m36]').change(function() {
			
		// 	if ($(this).prop('checked')) {
		// 		$( "#pdf" ).prop( "disabled", false );
		// 		$( "#pdf" ).hide( "slow");
		// 	}
		// });

		$('input[type=checkbox]').on('change', function() {
             if ($(this).is(':checked') ) {
                $( "#pdf" ).prop( "disabled", true );
                $( "#correo" ).prop( "disabled", true );
                alert("Hola estoy en true");
             } else {
                $( "#pdf" ).prop( "disabled", false );
                 $( "#correo" ).prop( "disabled", false );
                alert("Hola estoy en false");
            }
        });
  // 		$('input[type=checkbox]').change(function() {
		// 	if(this.value == 'personalizado'){
		// 		$('.mensaje').show('slow');
		// 	}else{
		// 		$('.mensaje').hide('slow');
		// 		$(".mensaje").val('');
		// 	}
		// });

		$('#carro').change(function() {
			if ($(this).prop('checked')) {
				showFiltrosCarro()
			}
		});

			/**
		 * Si se selecciona "moto" 
		 * se muestran los filtros de moto
		 * se ocultan los filtros de carro 
		*/


		$('#moto').click(function() {
			if ($(this).prop('checked')) {
				showFiltrosMoto();
			}
		});

		$('input[type=radio][name=tipo_mensaje]').change(function() {
			if(this.value == 'personalizado'){
				$('.mensaje').show('slow');
			}else{
				$('.mensaje').hide('slow');
				$(".mensaje").val('');
			}
		});

		$('.mensaje').change( function(){
			const mensaje = this.value;
			$('.mensaje_correo').each( function(){
				$(this).val(mensaje);
			} );
		} );

		function showInputsDeCilindradaMaxima(){
			$('#cilindrada_maxima').html("");
			cilindrada_minima = parseInt( $('#cilindrada_minima').val().replace(/\D/g,''));
			for (var i = 0; i <= 10; i++) {
				// console.log('i',i,'min:',cilindrada_minima);
				if( i*100 >= cilindrada_minima ){
					// console.log(i*100);

					if( '{{$request->cilindrada_maxima}}' == `${i*100}cc` ){
					$("#cilindrada_maxima").append(`<option value="${i*100}cc" selected>${i*100} CC</option>`);

					}else{
					$("#cilindrada_maxima").append(`<option value="${i*100}cc">${i*100} CC</option>`);

					}

				}
			}
		}

		$('#cilindrada_minima').change( function(){
			showInputsDeCilindradaMaxima()
		} );

		$(document).ready( function(){
			if($('#radio_button').is(':checked')) { 
				alert("it's checked");
			}

			if ($('#moto').prop('checked')) {
				showFiltrosMoto();
			}

			if ($('#carro').prop('checked')) {
				showFiltrosCarro();
			}

			showInputsDeCilindradaMaxima();
		
		} );

</script>
@endsection