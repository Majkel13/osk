<?php

namespace App\Http\Controllers\Kursant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\User;
use App\Role;
use App\Ride;
class JazdyController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:Kursant');
    }

    public function mojeJazdy(){

        $id=Auth::id();
        $jazdy=Ride::where('student',$id)->orderBy('status_id','desc')->orderBy('date','desc')->get();
        $kursant=User::where('id',$id)->first();
        
        if($kursant->amount==null){
            $ile_odbyte=0;
        }else{
            $ile_odbyte=$kursant->amount;
        }
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

    public function wolneTerminy(){
        $jazdy=Ride::where('status_id',1)->orderBy('date')->get();
        return view('jazdy.wolneTerminy',compact('jazdy'));
    }

    public function jazdySave(Ride $jazdy){
    
        $id=$jazdy->id;
        if($jazdy->checkData() ){
        $kursan_id=Auth::id();
        $j=Ride::
            where('student',$kursan_id)
            ->where('date',$jazdy->date)
            ->where(function($q)use ($jazdy){
                $q->whereBetween('time_start', array($jazdy->time_start,$jazdy->time_stop))
                ->orWhereBetween('time_stop', array($jazdy->time_start,$jazdy->time_stop));   
            })
            ->count();

            if($j!=0){
                return back()->with('er2','W podanym terminie masz już zaplanowaną jazdę');
            }
            
      // $jazda=Ride::where('id',$id)->first();
       $ile=$jazdy->amount_hours;

       $kursant=User::where('id',$kursan_id)->first();
       $amount2=$kursant->amount2;
       $amount2=$amount2+$ile;
       $amount=$kursant->amount;
       
       $jazda=Ride::where('id',$id)->update(['status_id'=>4,'student'=>$kursan_id]);
       $kursant=User::where('id',$kursan_id)->update(['amount2'=>$amount2]);

       if(($amount2+$amount)>30)
       {
        return back()->with('er3','Zapisano na jazdę dodatkową ponieważ przekroczono limit 30h darmowych');
       }
        return  back()->with('er','zapisano na jazde');
        }
        else{
            return back()->with('er2','Niestety zapisanie na tą jazdę nie jest już możliwe');
        }   
    }

    public function jazdyAnuluj(Ride $jazdy){
        
        if($jazdy->checkDataStudent() ){
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
            $jazda=Ride::where('id',$id)->update(['status_id'=>1,'student'=>null]);
            $jazda=Ride::where('id',$id)->first();
            return  back()->with('er2','Zrezygnowano z jazdy z dnia '.$jazda->data.' z godziny '.$jazda->godz_rozp);
        }else 
        return  back()->with('er2','Nie można już zrezygnować z tej jazdy');
    }
}
