<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Ride;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Carbon\Carbon;
class UserController extends Controller
{
    
    
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }
    public function addUser(){

        $roles=Role::all();
        return view('user.dodajUzytkownika',compact('roles'));
    }

    public function saveUser(Request $request){

        $validatedData = $request->validate([
            'email' => 'required|unique:users|max:45',
            'name' => 'required|max:45',
            'surname' => 'required|max:45',
            'phone' => 'required|max:15',
            'role_id' => 'required|integer|min:1|max:3'
        ]);
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $password = substr($random, 0, 8);
 
        $user=new \App\User();
        $user->email=$request->email;
        $user->name=$request->name;
        $user->surname=$request->surname;
        $user->phone=$request->phone;
        $user->password=bcrypt($password);
        $user->role_id=$request->role_id;
        $user->active=1;
        $user->save(); 

         $data = array(
            'name' => $user->name,
            'password' => $password
        );
        Mail::to($user->email)->send(new SendMail($data));
        return back()->with('success','Dodano użytkownika '.$user->name);
    }

    public function allUsers(){

        //$pracownicy= Role::find(2)->users;

        //$role=User::find(1)->role;
        //$users=\App\Role::find(1)->users();
        $role=Role::all();
        $users=User::where('active',1)->paginate(10);
        //$users1=new \App\User();

        return view('user.wszyscyUzytkownicy',compact('users','role'));
    }

  

    public function search(Request $request)
    {   
        if($request->ajax())
        {
            $output='';
            $name=$request->get('name');
            $surname=$request->get('surname');
            $phone=$request->get('phone');
            $email=$request->get('email');
            $role=$request->get('role');
            $active=$request->get('active');
            
            if($surname != '' || $name != '' || $phone != '' || $email != '' || $role != '' || $active!='')
            {
                if($active==-1){
                   $users = User::where('surname','like', '%'.$surname.'%')
                            ->where('name', 'like','%'.$name.'%')
                            ->where('phone', 'like' ,'%'.$phone.'%')
                            ->where('email', 'like' ,'%'.$email.'%')
                            ->where('role_id','like', '%'.$role)
                            ->get();  
                }else{
                    $users = User::where('surname','like', '%'.$surname.'%')
                    ->where('name', 'like','%'.$name.'%')
                    ->where('phone', 'like' ,'%'.$phone.'%')
                    ->where('email', 'like' ,'%'.$email.'%')
                    ->where('role_id','like', '%'.$role)
                    ->where('active',$active)
                    ->get(); 
                }
               
            }
            else
            {
                $users = User::all();
            }

            if($users->count()==0)
            {
                $output='Brak danych';
            }

            foreach($users as $user)
            {
                if($user->active==1){
                    if($user->role->name=="Kursant"){
                        $output.='
                        <tr>
                            <td>'.$user->name.'</td>
                            <td>'.$user->surname.'</td>
                            <td>'.$user->email.'</td>
                            <td>'.$user->phone.'</td>
                            <td>'.$user->role->name.'</td>
                            <td> <div class="form-check"><input class="form-check-input  mx-auto" type="checkbox" id="" value="" checked disabled></div>
                            
                            <td><a href="/wszyscyUzytkownicy/edycjaa/'.$user->id.'"><button  type="button" class="btn btn-primary">Edytuj</button></a></td>
                            <td><a href="/wszyscyUzytkownicy/info/'.$user->id.'"><button  type="button" class="btn btn-success">Info</button></a></td>
                        </tr>';
                    }else{
                        $output.='
                        <tr>
                            <td>'.$user->name.'</td>
                            <td>'.$user->surname.'</td>
                            <td>'.$user->email.'</td>
                            <td>'.$user->phone.'</td>
                            <td>'.$user->role->name.'</td>
                            <td> <div class="form-check"><input class="form-check-input  mx-auto" type="checkbox" id="" value="" checked disabled></div>
                            
                            <td><a href="/wszyscyUzytkownicy/edycjaa/'.$user->id.'"><button  type="button" class="btn btn-primary">Edytuj</button></a></td>
                            <td>--</td>
                        </tr>';
                    }
                 
                }else{
                    if($user->role->name=="Kursant")
                    {
                       $output.='
                    <tr>
                        <td>'.$user->name.'</td>
                        <td>'.$user->surname.'</td>
                        <td>'.$user->email.'</td>
                        <td>'.$user->phone.'</td>
                        <td>'.$user->role->name.'</td>
                        <td> <div class="form-check"><input class="form-check-input  mx-auto" type="checkbox" id="" value=""  disabled></div>
                        
                        <td><a href="/wszyscyUzytkownicy/edycjaa/'.$user->id.'"><button  type="button" class="btn btn-primary">Edytuj</button></a></td>
                        <td><a href="/wszyscyUzytkownicy/info/'.$user->id.'"><button  type="button" class="btn btn-success">Info</button></a></td>
                    </tr>'; 
                    }
                      else
                      {
                        $output.='
                     <tr>
                         <td>'.$user->name.'</td>
                         <td>'.$user->surname.'</td>
                         <td>'.$user->email.'</td>
                         <td>'.$user->phone.'</td>
                         <td>'.$user->role->name.'</td>
                         <td> <div class="form-check"><input class="form-check-input  mx-auto" type="checkbox" id="" value=""  disabled></div>
                         
                         <td><a href="/wszyscyUzytkownicy/edycjaa/'.$user->id.'"><button  type="button" class="btn btn-primary">Edytuj</button></a></td>
                         <td>--</td>
                     </tr>'; 
                     }
                }
                   
            }
            $link="";
            $users = array (
                'table_data' => $output,
                'link'  => $link,
               
            );

            echo json_encode($users);

        }
    }

    public function kursantInfo(User $kursant){

        $id=$kursant->id;
        $jazdy=Ride::where('student',$id)->orderBy('date','desc')->get();
        //$instruktor=Jazdy::find(1)->instruktor;
        //$jazdy=App\User::find(1)->jazdy;
        //$j=Jazdy::where('id',36)->first();
        
        //$kursant=User::where('id',$id)->first();
        $ile_odbyte=$kursant->amount;
        $ile_zaplanowane=$kursant->amount2;

        $procent_odbyte=($ile_odbyte/30.0)*100;
        $procent_zaplanowany=($ile_zaplanowane/30.0)*100;

        if(($ile_zaplanowane+$ile_odbyte)<=30){
            $ile_nieodbyte=30-($ile_odbyte+$ile_zaplanowane);
            
            $procent_nieodbyte=100-($procent_odbyte+$procent_zaplanowany);
            $ile_dodatkowe=0;
            $procent_dodatkowe=0;
        }else{
           
            
            $ile_nieodbyte=0;
            $procent_nieodbyte=0;
            $ile_dodatkowe=($ile_zaplanowane+$ile_odbyte)-30;
            $procent_dodatkowe=100;

            if($ile_odbyte<30){
                $ile_zaplanowane=30-$ile_odbyte;
            }else{
                $ile_zaplanowane=0;
            }
        }
        

        return view('jazdy.mojeJazdyK',compact('jazdy','ile_odbyte','ile_nieodbyte','ile_zaplanowane','ile_dodatkowe','procent_odbyte','procent_dodatkowe','procent_nieodbyte','procent_zaplanowany'));
       }

    public function edycja(User $user){

        $roles=Role::all();
        return view('user.edycjaUser',compact('user','roles'));
    }

    public function raport(){
        $instruktor=User::where('role_id',2)->get();

        $kursant=User::where('role_id',3)->where('active',1)->get();
        return view('user.raporty',compact('instruktor','kursant'));
    }
    
    public function exportRaport(Request $request)
    {
        $data_start=$request->data_start;
        $data_stop=$request->data_stop;
        $instruktor_id=$request->instruktor;
        $instruktor=null;

        
        if($instruktor_id==-1){
            if($data_start !='' && $data_stop !=''){
                $ile_wszystkie=Ride::whereBetween('date', array($data_start,$data_stop))->sum('amount_hours');
                                
                $ile_zapolanowane=Ride::whereBetween('date', array($data_start,$data_stop))                           
                ->where('status_id',4)->sum('amount_hours');

                $ile_wolne=Ride::whereBetween('date', array($data_start,$data_stop))
                ->where('status_id',1)->sum('amount_hours');
                
                $ile_odbyte=Ride::whereBetween('date', array($data_start,$data_stop))
                ->where('status_id',3)->sum('amount_hours');

                $ile_nieOdbyte=Ride::whereBetween('date', array($data_start,$data_stop))
                ->where('status_id',5)->sum('amount_hours');
                
                $ile_anulowane=Ride::whereBetween('date', array($data_start,$data_stop))
                ->where('status_id',2)->sum('amount_hours'); 

            }elseif($data_start=='' && $data_stop!='')
            {
                $ile_wszystkie=Ride::where('date', '<',$data_stop)->sum('amount_hours');
                                
                $ile_zapolanowane=Ride::where('date', '<',$data_stop)                         
                ->where('status_id',4)->sum('amount_hours');

                $ile_wolne=Ride::where('date', '<',$data_stop)
                ->where('status_id',1)->sum('amount_hours');
                
                $ile_odbyte=Ride::where('date', '<',$data_stop)
                ->where('status_id',3)->sum('amount_hours');

                $ile_nieOdbyte=Ride::where('date', '<',$data_stop)
                ->where('status_id',5)->sum('amount_hours');
                
                $ile_anulowane=Ride::where('date', '<',$data_stop)
                ->where('status_id',2)->sum('amount_hours'); 
            }elseif($data_stop=='' && $data_start!='')   
               {
                $ile_wszystkie=Ride::where('date', '>',$data_start)->sum('amount_hours');
                                
                $ile_zapolanowane=Ride::where('date', '>',$data_start)                         
                ->where('status_id',4)->sum('amount_hours');

                $ile_wolne=Ride::where('date', '>',$data_start)
                ->where('status_id',1)->sum('amount_hours');
                
                $ile_odbyte=Ride::where('date', '>',$data_start)
                ->where('status_id',3)->sum('amount_hours');

                $ile_nieOdbyte=Ride::where('date', '>',$data_start)
                ->where('status_id',5)->sum('amount_hours');
                
                $ile_anulowane=Ride::where('date', '>',$data_start)
                ->where('status_id',2)->sum('amount_hours');
               }
            else
            {
                $ile_wszystkie=Ride::sum('amount_hours');
                                
                $ile_zapolanowane=Ride::where('status_id',4)->sum('amount_hours');

                $ile_wolne=Ride::where('status_id',1)->sum('amount_hours');
                
                $ile_odbyte=Ride::where('status_id',3)->sum('amount_hours');

                $ile_nieOdbyte=Ride::where('status_id',5)->sum('amount_hours');
                
                $ile_anulowane=Ride::where('status_id',2)->sum('amount_hours');
            }
        }
        else{
            if($data_start !='' && $data_stop !='')
            {
                $ile_wszystkie=Ride::where('instructor',$instruktor_id)
                                ->whereBetween('date', array($data_start,$data_stop))->sum('amount_hours');
                                
                $ile_zapolanowane=Ride::where('instructor',$instruktor_id)
                ->whereBetween('date', array($data_start,$data_stop))                           
                ->where('status_id',4)->sum('amount_hours');

                $ile_wolne=Ride::where('instructor',$instruktor_id)
                ->whereBetween('date', array($data_start,$data_stop))
                ->where('status_id',1)->sum('amount_hours');
                
                $ile_odbyte=Ride::where('instructor',$instruktor_id)
                ->whereBetween('date', array($data_start,$data_stop))
                ->where('status_id',3)->sum('amount_hours');

                $ile_nieOdbyte=Ride::where('instructor',$instruktor_id)
                ->whereBetween('date', array($data_start,$data_stop))
                ->where('status_id',5)->sum('amount_hours');
                
                $ile_anulowane=Ride::where('instructor',$instruktor_id)
                ->whereBetween('date', array($data_start,$data_stop))
                ->where('status_id',2)->sum('amount_hours');  

            }elseif($data_start=='' && $data_stop!='')
            {
                 $ile_wszystkie=Ride::where('instructor',$instruktor_id)
                                ->where('date', '<',$data_stop)->sum('amount_hours');
                                
                $ile_zapolanowane=Ride::where('instructor',$instruktor_id)
                ->where('date', '<',$data_stop)                           
                ->where('status_id',4)->sum('amount_hours');

                $ile_wolne=Ride::where('instructor',$instruktor_id)
                ->where('date', '<',$data_stop)
                ->where('status_id',1)->sum('amount_hours');
                
                $ile_odbyte=Ride::where('instructor',$instruktor_id)
                ->where('date', '<',$data_stop)
                ->where('status_id',3)->sum('amount_hours');

                $ile_nieOdbyte=Ride::where('instructor',$instruktor_id)
                ->where('date', '<',$data_stop)
                ->where('status_id',5)->sum('amount_hours');
                
                $ile_anulowane=Ride::where('instructor',$instruktor_id)
                ->where('date', '<',$data_stop)
                ->where('status_id',2)->sum('amount_hours');  
            }elseif($data_stop=='' && $data_start!='')
            {
                 $ile_wszystkie=Ride::where('instructor',$instruktor_id)
                 ->where('date', '>',$data_start)->sum('amount_hours');
                                
                $ile_zapolanowane=Ride::where('instructor',$instruktor_id)
                ->where('date', '>',$data_start)                            
                ->where('status_id',4)->sum('amount_hours');

                $ile_wolne=Ride::where('instructor',$instruktor_id)
                ->where('date', '>',$data_start) 
                ->where('status_id',1)->sum('amount_hours');
                
                $ile_odbyte=Ride::where('instructor',$instruktor_id)
                ->where('date', '>',$data_start) 
                ->where('status_id',3)->sum('amount_hours');

                $ile_nieOdbyte=Ride::where('instructor',$instruktor_id)
                ->where('date', '>',$data_start) 
                ->where('status_id',5)->sum('amount_hours');
                
                $ile_anulowane=Ride::where('instructor',$instruktor_id)
                ->where('date', '>',$data_start) 
                ->where('status_id',2)->sum('amount_hours'); 
            }else{
                $ile_wszystkie=Ride::where('instructor',$instruktor_id)
                ->sum('amount_hours');
                               
               $ile_zapolanowane=Ride::where('instructor',$instruktor_id)                        
               ->where('status_id',4)->sum('amount_hours');

               $ile_wolne=Ride::where('instructor',$instruktor_id)
               ->where('status_id',1)->sum('amount_hours');       

               $ile_odbyte=Ride::where('instructor',$instruktor_id)
               ->where('status_id',3)->sum('amount_hours');

               $ile_nieOdbyte=Ride::where('instructor',$instruktor_id)
               ->where('status_id',5)->sum('amount_hours');
               
               $ile_anulowane=Ride::where('instructor',$instruktor_id)
               ->where('status_id',2)->sum('amount_hours'); 
            }
            
            $instruktor=User::where('id',$instruktor_id)->first();
           
        }
        
        
        $data_stop=strval($data_stop);
        $data_start=strval($data_start);
        
        $pdf=\App::make('dompdf.wrapper');
            $pdf->loadView('user/exportRaport',compact('instruktor','data_start','data_stop','ile_wszystkie','ile_zapolanowane',
        'ile_wolne','ile_odbyte','ile_nieOdbyte','ile_anulowane'));
            return $pdf->stream();   
    }

    public function exportRaportKursant(Request $request){
        $kursant_id=$request->kursant;
        $kursant=User::where('id',$kursant_id)->first();

        $ile_odbyte=Ride::where('student',$kursant_id)->where('status_id',3)->sum('amount_hours');
        $ile_zaplanowane=Ride::where('student',$kursant_id)->where('status_id',4)->sum('amount_hours');
        $ile_nieodbyte=Ride::where('student',$kursant_id)->where('status_id',5)->sum('amount_hours');

        $ile_dodatkowe=0;
        if($ile_odbyte>30){
            $ile_dodatkowe=$ile_odbyte-30;
        }
        $pdf=\App::make('dompdf.wrapper');
            $pdf->loadView('user/exportRaportKursant',compact('kursant','ile_zaplanowane','ile_odbyte','ile_nieodbyte','ile_dodatkowe'));
            return $pdf->stream();  
    }
    public function saveEdit(Request $request){
    
      
        if($request->lastEmail==$request->email){
            $validatedData = $request->validate([
                'email' => 'required|max:45',
                'name' => 'required|max:45',
                'surname' => 'required|max:45',
                'phone' => 'required|max:15',
                'role_id'=>'required|integer|min:1|max:3',
            ]);
        }else{
            $validatedData = $request->validate([
                'email' => 'required|unique:users|max:45',
                'name' => 'required|max:45',
                'surname' => 'required|max:45',
                'phone' => 'required|max:45',
                'role_id'=>'required|integer|min:1|max:3',
            ]);
        }    
       
        
          
        $user=User::where('id',$request->id)->update(['email'=>$request->email, 'name'=>$request->name
        ,'surname'=>$request->surname, 'phone'=>$request->phone, 'role_id'=>$request->role_id, 'active'=>$request->active]);
        return back()->with('success','Edycja zakończona pomyślnie');
    }
}
