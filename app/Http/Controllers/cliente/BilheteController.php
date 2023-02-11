<?php

namespace App\Http\Controllers\cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bilhete;
use App\Models\User;
use Hash;
 
class BilheteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Bilhete = Bilhete::join('users', 'users.id', '=', 'bilhetes.user_id')
            ->Where('bilhetes.id','=',$id)
            ->get(['bilhetes.*', 'users.name']);

            //dd($Bilhete);

        $res="";
        if($Bilhete){
            foreach($Bilhete as $bilhete){

        
           $res= "<div class = 'row-sl-6' >".
                    "<div class='card'>"
                        ."<div class='card-body'>"
                            ."<h5 class='card-title'>Bilhete nº : "."$bilhete->id"."</h5>"
                            ."<p class='card-text'> data de partida:".$bilhete->data_compra."</p>"
                            ."<p class='card-text'> origem:".$bilhete->name."</p>"
                                
                    
                        ."</div>"

                      
                        ."<div class='card-body'>"
                           

                                ."<a href=/actualizarBilhete/"."$bilhete->id". " class='btn btn-primary mx-2'> Alterar O Bilhete</a>"
                                
        
                                ."<a href=/reembolsarBilhete/"."$bilhete->id". " class='btn btn-primary mx-2'>Pedir Reembolso</a>"

                                ."<a href='' class='btn btn-primary mx-2'>Reclamar Milha</a>"


                    ."</div>"
                  
                    ."</div>"

                    
         
                ."</div>\n";
            }
        }
        else{
            $res="Nâo Existe Bilhete com Este codigo";
        }
        

        
        
        echo ($res);
        //
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $bilhete = Bilhete::join('users', 'users.id', '=', 'bilhetes.user_id')
        ->Where('bilhetes.id','=',$id)
        ->get(['bilhetes.*', 'users.name','users.surname']);

        return view('cliente/bilheteAlterar',['bilhete'=>$bilhete[0]]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->surname = $request->sobrenome;
        $user->gender = 'M';
        $user->password = Hash::make('usercli77');
        //$user->email = $request->email;
        $user->role_id = 3;
        $user->state = 1;
        $tel=$request->telefone;
        $user->save();

        $bilhete =Bilhete::find($request->id);
        $bilhete->data_compra=date("Y-m-d");
        $bilhete->save();


        dd("alterado com sucesso");
        
    }

    public function reembolsar($id)
    {
        //
        return view('cliente/bilheteRemb',['bi_id'=>$id]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
