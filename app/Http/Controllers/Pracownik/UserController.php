<?php

namespace App\Http\Controllers\Pracownik;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
   //
    
   public function __construct(){
    $this->middleware('auth');
    $this->middleware('role:Pracownik');
}
public function addUser(){

    $roles=Role::all();

    return view('user.dodajKursant',compact('roles'));
}

public function saveKursant(Request $request){

    //dd($request->all());

    $validatedData = $request->validate([
        'email' => 'required|unique:users|max:45',
        'name' => 'required|max:45',
        'surname' => 'required|max:45',
        'phone' => 'required|max:15',
    ]);
    $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $password = substr($random, 0, 8);
    
    $role=new \App\Role();
    $role->id=3;
    $user=new \App\User();
    $user->email=$request->email;
    $user->name=$request->name;
    $user->surname=$request->surname;
    $user->phone=$request->phone;
    $user->password=bcrypt($password);
    $user->role_id=3;
    $user->active=1;
    $user->save(); 

    $data = array(
        'name' => $user->name,
        'password' => $password
    );

    Mail::to($user->email)->send(new SendMail($data));
    return back()->with('success','Dodano uzytkonika '.$user->name.'');
}

public function allKursant(){

    $users=User::where('role_id',3)
                ->where('active',1)
                ->orderBy('surname')
                ->paginate(10);


    return view('user.wszyscyKursanci',compact('users'));
}

public function edycja(User $user){

    return view('user.edycja',compact('user'));
}

public function saveEdit(Request $request){

  
    if($request->lastEmail==$request->email){
        $validatedData = $request->validate([
            'email' => 'required|max:45',
            'name' => 'required|max:45',
            'surname' => 'required|max:45',
            'phone' => 'required|max:15',
        ]);
    }else{
        $validatedData = $request->validate([
            'email' => 'required|unique:users|max:45',
            'name' => 'required|max:45',
            'surname' => 'required|max:45',
            'phone' => 'required|max:15',
        ]);
    }    
   
    
      
    $user=User::where('id',$request->id)->update(['email'=>$request->email, 'name'=>$request->name
    ,'surname'=>$request->surname, 'phone'=>$request->phone]);
    return back()->with('success','Edycja zakończona pomyślnie');
}

}
