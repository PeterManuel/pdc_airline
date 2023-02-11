@extends('layouts.cliente')
@section('titulo', 'HOME')
@section('content')

<?php
    $enc = new App\Classes\Encri;
?>


  
	<header id="gtco-header" class="gtco-cover gtco-cover-md my-5" role="banner" style="background-image: url(/img/05.jpg)">
		<div class="overlay"></div>
        
		<div class="gtco-container">
            
			<div class="row">
				
            <!--começo-->
            <div class="col-md-12 col-md-offset-0 text-left " id="dados_viajem">
				
                <div class="container-fluid h-100" >
            <div class="row h-100 align-items-center justify-content-center text-center p-3">
                <div class="col-lg-12 align-self-end mb-4 page-title p-5">
                <div class="col-md-12 mb-2 text-left">
                    <div class="card">
                        <div class="card-body">

						<div class="row form-group m-2">
                                    <div class="col-sm-2 text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="trip" id="onewway" value="1" checked>
                                            <label class="form-check-label" for="onewway">
                                            Ida
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="trip" id="rtrip" value="2">
                                            <label class="form-check-label" for="rtrip">
                                            Ida e volta
                                            </label>
                                        </div>
                                    </div>
									<!--fim-->
                            
                                <div class="row form-group m-3">

									
                                    <div class="col-sm-3">
                                        <label for="" class="control-label">De</label>

                                        <select name="origem" id="departure_location" class="custom-select browser-default select2 form-control">
										@foreach($aeroportos as $aeroporto)
											<option value="{{$aeroporto->cidade}}">{{$aeroporto->cidade}}</option>
										@endforeach
                                            
                                        </select>
										<span class="text-danger error-text destino_err"></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="" class="control-label">Para</label>
                                        <select name="destino" id="destino" class="custom-select browser-default select2 form-control">
                                        @foreach($aeroportos as $aeroporto)
											<option value="{{$aeroporto->cidade}}">{{$aeroporto->cidade}}</option>
										@endforeach
										  
                                        </select>
										<span class="text-danger error-text destino_err"></span>
                                        
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="" class="control-label">Data de partida</label>
                                        <input type="date" class="form-control input-sm datetimepicker2" 
                                        name="data_partida" id="data_partida" autocomplete="off">
										<span class="text-danger error-text data_partida_err"></span>

                                    </div>
                                    <div class="col-sm-3" id="rdate" style="display: none">
                                        <label for="" class="control-label">Data de Volta</label>
                                        <input type="date" class="form-control input-sm datetimepicker2" 
                                        name="date_volta" autocomplete="off">
                                    </div>
									<span class="text-danger error-text data_volta_err"></span>
                                </div>
                                <div class="row form-group m-3">
                                    <div class="col-sm-3 ">
									<label for="" class="control-label">Classe</label>
									<select name="classe" id="classe" class="custom-select browser-default select2 form-control">
										@foreach($tarifas as $tarifa)
											<option value="{{$tarifa->nome}}">{{$tarifa->nome}}</option>
										@endforeach
										  
                                        </select>
                                    </div>
                                    <div class="col-sm-3 ">
									<label for="" class="control-label">Quantidade de Passageiros</label>
									
                            
                                        <input type="number"  class="form-control" name="qtd_pass" id="qtd_pass">
                                        <span class="text-danger error-text qtd_pass_err"></span>
                                    </div>
                                    <div class="col-sm-3 offset-sm-3 mt-4">
                                        <button class="btn btn-block btn-sm btn-primary" id="encontrar_voo" 
                                       ><i class="fa fa-plane-departure"></i>Encontar voos</button>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>                        
                </div>
                
            </div>
        </div>
            <!---->

					<div class="row row-mt-15em">
						<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
								
						</div>
						<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
							
						</div>
					</div>
							
					
				</div>
			</div>
		</div>
	</header>

	

	
	<div class="gtco-section">
		<div class="gtco-container2" >
			
			<div class="row" id="info">
				
			</div>
			<div class="row " id="lista_voo">
			
			
			
			</div>
		</div>
	</div>
	
	<div class="gtco-cover gtco-cover-sm" style="background-image: url(img/img_bg_1.jpg)"  data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="gtco-container text-center">
			<div class="display-t">
				<div class="display-tc">
					<h1>Temos serviços de alta qualidade que você certamente vai adorar!!</h1>
				</div>	
			</div>
		</div>
	</div>

	
	</div>
<!--fim-->
	</div>
	
<script src="/js/cliente.js"></script>
<script type="text/javascript">


</script>


@endsection

