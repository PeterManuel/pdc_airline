@extends('layouts.cliente')
@section('titulo', 'SELECIONAR LUGAR')
@extends('layouts.sidebar')
@section('content')
 


<br><br><br>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Iniciar Sessao</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('login.user') }}" method="post">
		@csrf
			<div class="py-3">
				<input type="text" name="email" id="email" placeholder="E-mail" class="form-control" value="{{old('email')}}" 
				required autofocus>
				@error('email')
                    <span class="text-danger"><small>{{$message}}</small></span>
                @enderror
			</div>

			<div>
				<input type="text" name="password" id="password" placeholder="Palavra Passe" class="form-control" value="{{old('password')}}"
				required autofocus>
				@error('password')
                    <span class="text-danger"><small>{{$message}}</small></span>
                @enderror
			</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Iniciar Sessao</button>
      </div>
	  </form>
	  <p>Esqueceu-se da palavra passe? <a href="/recuper_password">Recupere palavra passe</a></p> 
    </div>
  </div>
</div>

<div class="container">
<div class="row mb-5" >

    <div class="col-sm-8" >

    <div class="card" hidden>
    <div class="card-header">
        Featured
    </div>
    <div class="card-body">
        <h4>PARTIDA</h4>
       <span id="partida">
       {{date('d/m/Y', strtotime($voo->data_partida))}}
    </span> 
    <span id="regresso">
       {{date('d/m/Y', strtotime($voo->data_regresso))}}
    </span> 
    <span id="hora_partida_cidade_origem">
      <strong> {{date('H:i', strtotime($voo->data_partida))}}</strong> {{$partida->cidade}}
    </span>
    <span id="hora_partida_cidade_destino">
      <strong>{{date('H:i', strtotime($voo->data_regresso))}}</strong> {{$regresso->cidade}}
    </span>

        
        <p>{{$partida->cidade}} ----------- <ion-icon name="airplane-outline"></ion-icon> ------------ {{$regresso->cidade}}</p>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <hr>
        <h4>REGRESSO</h4>
        <p>{{$regresso->cidade}} ----------- <ion-icon name="airplane-outline"></ion-icon> ------------ {{$partida->cidade}}</p>

        
            <p class="text-right">1500</p>
            <p class="text-right">Por passageiro</p>
        
            <div class="col-md-2 offset-5" >
                <button type="button" class="btn btn-primary">Selecionar</button>
            </div>  
    </div>
    </div>
</div>
</div>
</div>
<div class="container py-5">
<div class="row">
    <div class="col-8">
        <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                        <input  type='text'  id='id_voo' value="{{$voo->id}}" hidden>
                        <label for="" class="control-label">Passgeiros:</label>
                        <br>
										<div class="dropdown">
											<button class="dropbtn">
												<span id="passageiros" >1 passageiro</span>
											</button>
										<!--Adulto-->
											<div class="dropdown-content p-2">
                                                <div class="row">
												<div class="col-md-12">
														<div class="passageiro-number">
															<label for="">Adulto</label>
															<div class="counter pull-right __web-inspector-hide-shortcut__">
																<span class="rounded-circle bg-primary p-2" onclick="decrementar('adults-number', 'Adulto')">-</span>
																	<input maxlength="1" type="text" id="adults-number" name="adults" value="1" disabled="">
																<span class="rounded-circle bg-primary p-2" onclick="increment('adults-number','Adulto')" >+</span>
															</div>
														</div>
												</div><!--fim passageiro-->  
                                                </div>
                                                <!--Criança-->
                                                <div class="row">
												<div class="col-md-12">
														<div class="passageiro-number">
                                                         <label for="">criança</label>
															<div class="counter pull-right __web-inspector-hide-shortcut__">
																<span class="rounded-circle bg-primary p-2" onclick="decrementar('crianca-number', 'crianca')">-</span>
																	<input maxlength="1" type="text" id="crianca-number" name="crianca-number" value="0" disabled="">
																<span class="rounded-circle bg-primary p-2" onclick="increment('crianca-number', 'crianca')" >+</span>
															</div>
														</div>
												</div><!--fim passageiro-->  
                                                </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="" class="control-label">Classe</label>
							<select name="classe" id="classe" class="custom-select browser-default select2 form-control">
										@foreach($tarifas as $tarifa)
											<option value="{{$tarifa->preco}}">{{$tarifa->nome}}</option>
										@endforeach			  
                            </select>
                            <input type="button"  value="selecionar" onclick="selecionarTarifa()">
                        </div>
                    </div>

                   
                </div>
        </div>
    </div>
            <div class="col-4">
            </div>
    </div>
</div>
<div id='qtd_passageiros' hidden>1</div>

<!--detalhes-->

<aside class="component-container  col-xs-6 ">

<div class="card" style="width: 30rem;">
  <img src="/img/paris.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <h3 class="card-title">A sua reserva</h3>
        <span id="adult"></span>    <span id="crian"></span>
        <div id="data_partida"></div>
        <div id="hor_cidade_origem"></div>
        <div id="hor_cidade_destino"></div>
        <div id="tarif"></div>
        <div id="preco_total"></div>
        <div id="preco"></div>
        <div id="data_regresso"></div>
  </div>
</div>

</aside>

<!--fim detalhes-->

<!--selecionar lugar-->
<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="escolher_lugar">
                <p><strong class="text-success">Corredor ou janela?</strong> Escolhe o teu lugar agora para evitares deceções</p>
            </div>
            
            <div class="py-5">
                <h3>{{$partida->cidade}} - {{$regresso->cidade}}</h3> 
                @auth
                @else
                </div>
                <p>Deseja fazer a compra como membro?<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalLong">Iniciar Sessao</button></p>
                <div>
                @endauth
            

            </div>
        </div>
        <div class="col-4">
        </div>
    </div><!--fim da row-->

                <div class="row">
                    <div class="col-3">
                        <span id="livre" class="text-white bg-primary py-1 px-3 mx-2"></span> 
                        <span class="text-dark">Livre</span>
                        <span id="ocupado" style="background-color:black" class="text-white py-1 px-3 mx-2"></span> 
                        <span class="text-dark">ocupado</span>
                        <span id="selecionado" class="text-white bg-success py-1 px-3 mx-2"></span>  
                        <span class="text-dark">selecionado</span> 
                        <hr> 
                    </div>   
                    <div class="col-9">  
                        
                    </div>
                </div><!--fim row2-->
            <div class="row">
                <div class="col-2">
                 <p>Todos os lugares</p>
                 @php
                
                    foreach($lugares as $lugar){
                        if(in_array($lugar->id,$array_lugares_ocupados)){
            @endphp
            <span id="@php echo $lugar->id @endphp" style="background-color:black" class="place text-white my-3 py-6 px-3 mx-2 " >@php echo $lugar->id @endphp</span>
                    @php     }else{ @endphp
                        <span id="num@php echo $lugar->id @endphp" style="background-color:blue" class="place text-white my-3 py-6 px-3 mx-2 point" onclick="selec_lug(@php echo $lugar->id @endphp)" value="@php echo $lugar->id @endphp">@php echo $lugar->id @endphp</span>
                       @php    
                        }
                    }
                    @endphp

                 
                 <div class="container py-4">
                    <button class="btn btn-primary btn-sm" onclick="getUser()" >Seguinte</button>
                </div>
                </div>
                
                <div class="col-10" id="pass_lugares"></div>
                <div id="preco_apagar" hidden></div>
        
            </div><!--fim row3-->
            </div>


  

    
    <input  type='text'  id='num_lugar' name="num_lugar" hidden>
    <input  type='text'  id='id_voo' name="{{$voo->id}}" hidden>
    

<script src="/js/selec_lugar.js"></script>
<script src="/js/teste.js"></script>
<script type="text/javascript">
</script>
@endsection
