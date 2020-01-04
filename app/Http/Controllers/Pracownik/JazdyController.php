<?php

namespace App\Http\Controllers\Pracownik;


use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\Ride;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
class JazdyController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:Pracownik');
    }


    public function mojeJazdy(){

        $id=Auth::id();
        $jazdy=Ride::where('instructor',$id)
                    ->whereIn('status_id',[1,4])
                    ->orderBy('date','asc')            
                    ->paginate(10);
                    
        //$instruktor=Jazdy::find(1)->instruktor;
        //$jazdy=App\User::find(1)->jazdy;
        $mytime = Carbon::now();
        $dateNow=$mytime->toDateString();
        $timeNow=$mytime->toTimeString();
        return view('jazdy.mojeJazdyP',compact('jazdy','dateNow','timeNow'));
    }

    public function dodajJazdy(){
        //$id=Auth::id();
        $kursanci=User::where('role_id',3)->where('active',1)->get();
        return view('jazdy.dodajJazdy',compact('kursanci'));
    }

    public function saveJazdy(Request $request){
        $godz1=$request->godz_rozp;
        $godz2=$request->godz_zak;
        $data=$request->data;
        $ile=$request->ile;
        $validatedData = $request->validate([
            'godz_rozp' => 'required',
            'godz_zak' => 'required',
            'data' => 'required',
            'ile' => 'required',
        ]);
        $mytime = Carbon::now();
        $dateNow=$mytime->toDateString();
        $timeNow=$mytime->toTimeString();
        if($data<$dateNow || ($data==$dateNow && $timeNow>=$godz1) || $godz2<$godz1 || ($ile!=1 && $ile!=2 && $ile!=3) )
        { return back()->with('er','Źle wprowadzone dane do formularza'); }
        $j=Ride:: 
            where('instructor',Auth::id())
            ->where('date',$data)
            ->where(function($q)use ($request){
                $q->whereBetween('time_start', array($request->godz_rozp,$request->godz_zak))
                ->orWhereBetween('time_stop', array($request->godz_rozp,$request->godz_zak));   
            })
            ->count();
            if($j!=0){
                return back()->with('er','W podanym terminie masz już zaplanowaną jazdę');
            }
           if($request->kursant!=null){//jesli podano kursanta to sprawdzam czy on nie ma juz jazd
            $id_kursant=$request->kursant;
                $j=Ride::
                where('student',$id_kursant)
                ->where('date',$data)
                ->where(function($q)use ($request){
                    $q->whereBetween('time_start', array($request->godz_rozp,$request->godz_zak))
                    ->orWhereBetween('time_stop', array($request->godz_rozp,$request->godz_zak));   
                })
                ->count();
                if($j!=0){return back()->with('er','W podanym terminie kursant ma już zaplanowaną jazdę');}
           } 
        $jazdy = new Ride();
        $jazdy->date=$request->data;
        $jazdy->time_start=$request->godz_rozp;
        $jazdy->time_stop=$request->godz_zak;
        $jazdy->amount_hours=$request->ile;
        if($request->kursant==null){
            $jazdy->status_id=1;
            $jazdy->student=$request->kursant;
            $jazdy->instructor=Auth::id();
            $jazdy->save();
           
        }else{
            $ile=$jazdy->amount_hours;
            $jazdy->status_id=4;
            $user=User::where('id',$id_kursant)->first();
            $amount2=$user->amount2;
            $amount=$user->amount;
            $amount2=$amount2+$ile;
            $jazdy->student=$request->kursant;
            $jazdy->instructor=Auth::id();
            $k=User::where('id',$id_kursant)->update(['amount2'=>$amount2]);
            $jazdy->save();
            if(($amount2+$amount)>30)
            {
                return back()->with('er','Zapisano kursanta na dodatkową jazdę ponieważ przekroczono limit 30 darmowych godzin ');
            }
        }
       return back()->with('success','Dodano jazde ');
    }

    public function jazdyAnuluj(Ride $jazdy){
        
        if($jazdy->checkData() ){
            $id=$jazdy->id;
            
            if($jazdy->student!=null){
                $id_kursant=$jazdy->student;
                $jazda=Ride::where('id',$id)->first();
                $ile=$jazda->amount_hours;
                $kursant=User::where('id',$id_kursant)->first();
                $amount2=$kursant->amount2;
                $amount2=$amount2-$ile;
                $kursant=User::where('id',$id_kursant)->update(['amount2'=>$amount2]);
            }
            $jazda=Ride::where('id',$id)->update(['status_id'=>2]);
            $jazda=Ride::where('id',$id)->first();
            return  back()->with('er2','Anulowano jazde z dnia '.$jazda->datE.' z godziny '.$jazda->time_start);
        }else 
        return  back()->with('er2','Nie można już anulować tej jazdy');
    }

    public function jazdyOk(Ride $jazdy){

        $id=$jazdy->id;
            
        $jazda=Ride::where('id',$id)->update(['status_id'=>3]);
        $jazda=Ride::where('id',$id)->first();
        $ile=$jazda->amount_hours;

        $id_kursant=$jazda->student;
        $user=User::where('id',$id_kursant)->first();
        
        $amount2=$user->amount2;
        $amount2=$amount2-$ile;

        $amount=$user->amount;
        $amount=$amount+$ile;

        $user=User::where('id',$id_kursant)->update(['amount'=>$amount, 'amount2'=>$amount2]);

        return  back()->with('er','Dodano jazde do pomyślnie odbytych');
    
    }

    public function jazdyNo(Ride $jazdy){
 
        $id=$jazdy->id;
        if($jazdy->student!=null){
            $id_kursant=$jazdy->student;
            $jazda=Ride::where('id',$id)->first();
            $ile=$jazda->amount_hours;
            $kursant=User::where('id',$id_kursant)->first();
            $amount2=$kursant->amount2;
            $amount2=$amount2-$ile;
            $kursant=User::where('id',$id_kursant)->update(['amount2'=>$amount2]);
        }
        $jazda=Ride::where('id',$id)->update(['status_id'=>5]);

        return  back()->with('er2','Dodano jazdy do nieodbytch');
    }
}
