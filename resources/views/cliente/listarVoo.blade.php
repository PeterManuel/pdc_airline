@extends('layouts.cliente')
@section('titulo', 'Lista de voos')
@section('content')

<br><br><br><br>
<main class="signup-form">
    <div class="cotainer">  
        
 
        <div class="row justify-content-center px-4">
          
	    <h1>Listas de Voo Disponiveis</h1>

        </div>


        <div class="row justify-content-center">
          
     
        @foreach($voos as $voo)
				<div class="col-lg-4 col-md-4 col-sm-6">
					<a href="" class="fh5co-card-item">
						
							<img src="../img/paris.jpg" alt="Image" class="img-responsive">
					
						<div class="fh5co-text">
							<h2>{{$voo->destino->cidade}} - {{$voo->destino->pais}}</h2>
							<p></p>
							<p> data de partida :{{$voo->data_partida}}</p>
                            

                            <p><span class="btn btn-primary">Compra já</span></p>
						</div>
					</a>
				</div>
			@endforeach



        </div>



        

        </div>
    </div>
</main>
@endsection