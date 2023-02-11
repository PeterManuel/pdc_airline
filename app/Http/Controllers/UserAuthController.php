<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ValidarForm;
use App\Classes\Encri;
use Hash;
use Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Membro;
use App\Models\Voo;
use App\Models\Tarifa;
use App\Models\Reclamacao;
use App\Models\Reembolso;
use App\Models\Bilhete;
use App\Models\Lugar;
use App\Models\Passageiro;
use App\Models\Referencia;
use App\Models\Preferencia;
use Illuminate\Support\Facades\Auth;
class UserAuthController extends Controller
{

    private $Encri;

    public function __construct(){
        $this->Encri = new Encri();
    }

    public function index()
    {
        return view('auth.login'); 
    }  
      
    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
  
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.registration');
        
    }

    public function recuper_password(){

        return view('recuper_password');
    }

    public function recuperar(Request $request){

        $membro = Membro::where('email', $request->email)->first();
        $request->session()->put(['email' => $membro->email]);
        
        if($membro){
           // dd($membro);
            Mail::send('mail.pdcairline', ['membro' => $membro], function($m){
                $m->from('muchombo2021@gmail.com', 'Felismino');
                //$m->to($request->email);
                $m->to(request()->session()->get('email'));
                
            });
        }else{
            echo 'Email inexistente';
        }  
    }
    
    public function gerarPdf(){

        $user = auth()->user();
        $user_log = User::where('id', $user->id)->first();
        $pdf = Pdf::loadView('gerarpdf', compact('user_log'));
        
       return $pdf->setPaper('a4')->stream('bilhete.pdf');
       //return $pdf->setPaper('a4')->download('bilhete.pdf');
    }

    public function getMembro(){
              
        $user = auth()->user();
        $membro = Membro::where('user_id', $user->id)->first();
        //dd($membro);
        //$membro = Membro::where('user_id', $user->id)->first();
       // dd($membro);
        return view('membro.dashboard', ['membro' => $membro]);
    }

    public function membro_logado(){
        
        $user = auth()->user();
        $membro = User::where('id', $user->id)->first();
        if($membro){
            return $membro->email;
        }
        return false;  
    }

    public function getUser(){

        $user = auth()->user();
        $membro = Membro::where('user_id', $user->id)->first();
        $user_membro = User::where('id', $user->id)->first();
       // dd($membro->birthday->format('Y-m-d'));
        //echo $membro->telefone;
        
        return view('membro.dados_user', ['membro' => $membro]);
    }

    public function getDashMembro(){

        return view('membro.dashboard');
    }

    
      
    public function userRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    

    public function comprar_bilhete_com_milha(){

        $voos = Voo::all();

        return view('compra_com_milha', ['voos' => $voos]);
    }

    public function get_info_milha(){

        return view('membro.info_milha');
    }

    public function reclamar_milha(){

        $user = auth()->user();
        $user_membro = User::where('id', $user->id)->first();

        return view('membro.reclama_milha', [ 'user_membro' => $user_membro]);
    }

    public function dados_reclame(Request $request){

        $reclamacao = new Reclamacao;
        $reclamacao->bilhete_id = $request->num_bilhete;
        $reclamacao->descricao = $request->descricao;
        $reclamacao->save();

        //por a mensagem de sucesso
        return redirect('/membro-dashboard');
    }

    public function conf_bilhete(){

        return view('conf_bilhete');
    }

    public function teste(Request $request, $id_voo, $adult, $lugares, $crianca=null){
       //dd($id_voo);
        if($crianca!=null){
            $crianca = $crianca;
        }
        
        json_decode($lugares);
        $lugares = explode(",", $lugares);
        $request->session()->put(['lugares' => $lugares]);

        return view('users', ['lugares' => $lugares, 'adult' => $adult, 'crianca' => $crianca, 'id_voo' => $id_voo]);
    }


    public function update($id){
        
        $user = User::findOrfail($id);
        $user->name = request('name');
        $user->surname = request('sobrenome');
        $user->gender = request('genero');
        $user->email = request('email');
        $user->password = Hash::make(request('password'));
        $user->phone = request('telefone');
        $user->save();

        $membro = Membro::where('user_id', $id)->first();
        $preferencia =Preferencia::findOrfail($membro->preferencia_id);
        $preferencia->refeicao = request('comida');
        $preferencia->lugar = request('lugar');
        $preferencia->save();

        
        $membro->birthday = request('data_nasc');
        $membro->idiom = request('idioma');
        $membro->address = request('morada');
        $membro->email = request('email');
        $membro->pass = request('password');
        $membro->miles = 0;
        $membro->user_id = $user->id;
        $membro->preferencia_id = $preferencia->id;
        $membro->save();

        return redirect('/dados_user')->with('msg', 'Actualizado com Sucesso');
    }
    
    public function info_passageiro(Request $request){
        
        $lugares = $request->session()->get('lugares');

        if(auth()->user()){
            $user = auth()->user();
        }else{
            $user = new User;
            $user->name = $request->nameadulto1;
            $user->gender = $request->sexoadulto1;
            $user->role_id = 3;
            $user->save();

            $passageiro = new Passageiro;
            $passageiro->user_id = $user->id;
            $passageiro->save();
        }
        
        $referencia = new Referencia;
        $ref_gerada = $this->Encri->encriptar(rand(0, 1000093876423467));
        $referencia->nome = $ref_gerada;
        $referencia->user_id = $user->id;
        $referencia->save();
        
        $bilhete = new Bilhete;
        $bilhete->user_id = $user->id;
        $bilhete->voo_id = $request->id_voo;
        $bilhete->save();
        $voo = Voo::where('id', $request->id_voo)->first();
    //dd($voo);
        for($i=0; $i<count($lugares); $i++){

            $voo->lugares()->attach($lugares[$i]);

        }
        return view('referencia_user', ['ref_gerada' => $ref_gerada, 'voo' => $voo]);
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('admin/dashboard');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('home');
    }

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

                    ."</div>"
                  
                    ."</div>"

                ."</div>\n";
            }
        }
        else{
            $res="Nâo Existe Bilhete com Este codigo";
        }
  
        echo ($res);

    }

    public function reembolsar($id)
    {
        
        return view('bilheteRemb',['bi_id'=>$id]);
    }

    public function reembolso_create(Request $request){

        $reembolso = new Reembolso;
        $reembolso->bilhete_id = $request->bi_id;
        $reembolso->descricao = $request->descricao;
        $reembolso->save();

    }
}