<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Ride;
use App\User;
use App\Status;
use App\Http\Controllers\Controller;
use Auth;
use PDF;
class JazdyController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:Admin');
        

    }

    public function wszystkieJazdy(){

        //$kur=Jazdy::find(1)->kursant;
        $status=Status::all();
        $instruktor=User::where('role_id',2)->get();
        $kursanci=User::where('role_id',3)->get();
        $jazdy=Ride::orderBy('date','desc')->paginate(10);
       // $jazdy=Jazdy::all();

        return view('jazdy.wszystkieJazdy',compact('jazdy','instruktor','kursanci','status'));
    }

   
    //////////////EDYCJA/////////////////////

    // public function edycja(Jazdy $jazda){
    //     $instruktorzy=User::where('role_id',2)->get();
    //     $kursanci=User::where('role_id',3)->get();
    //     return view('jazdy.edytujJazdy',compact('jazda','instruktorzy','kursanci'));
    // }
    // public function edycjaZapisz(Request $request){

    //     $godz1=$request->godz_rozp;
    //     $godz2=$request->godz_zak;
    //     $data=$request->data;
    //     $inst=$request->instruktor;
        
    //    // $j2=Jazdy::where('id',$request->id);


    //     $j=Jazdy:: 
    //         where('instruktor',$inst)
    //         ->where('data',$data)
    //         ->where(function($q)use ($request){
    //             $q->whereBetween('godz_rozp', array($request->godz_rozp,$request->godz_zak))
    //             ->orWhereBetween('godz_zak', array($request->godz_rozp,$request->godz_zak));   
    //         })
    //         ->get();

            
    //         if($j->count()!=0){
    //             return back()->with('er','W podanym terminie instruktor ma już zaplanowaną jazdę');
    //         }

    //        if($request->kursant!=null){//jesli podano kursanta to sprawdzam czy on nie ma juz jazd
    //         $id_kursant=$request->kursant;
    //             $j=Jazdy::
    //             where('kursant',$id_kursant)
    //             ->where('data',$data)
    //             ->where(function($q)use ($request){
    //                 $q->whereBetween('godz_rozp', array($request->godz_rozp,$request->godz_zak))
    //                 ->orWhereBetween('godz_zak', array($request->godz_rozp,$request->godz_zak));   
    //             })
    //             ->count();

    //             if($j!=0){
    //                 return back()->with('er','W podanym terminie kursant ma już zaplanowaną jazdę');
    //             }

    //        } 
               
            
    //     $jazdy = new Jazdy();

    //     $jazdy->data=$request->data;
    //     $jazdy->godz_rozp=$request->godz_rozp;
    //     $jazdy->godz_zak=$request->godz_zak;
    //     $jazdy->ile_godz=$request->ile;

    //     if($request->kursant==null){
    //         $jazdy->status_id=1;
    //     }else{
    //         $ile=$jazdy->ile_godz;
    //         $jazdy->status_id=4;
    //         $user=User::where('id',$id_kursant)->first();
    //         $amount2=$user->amount2;
    //         $amount=$user->amount;
    //         $amount2=$amount2+$ile;
    //         if(($amount2+$amount)>30)
    //         {
    //             return back()->with('er','Nie można dodać jazdy z tym kursantem ponieważ przekroczy to limit 30h');
    //         }
    //         $k=User::where('id',$id_kursant)->update(['amount2'=>$amount2]);
    //     }

    //     $jazdy->kursant=$request->kursant;
    //     $jazdy->instruktor=$inst;
        
    //     $jazdy->save();

    //    return back()->with('success','Dodano jazde ');

    // }

    public function export(Request $request){
      
      
            //  $output="<!DOCTYPE html>
            //  <html lang='pl'>
            //  <head>
            //  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            //  </head>
            //  <body>
            //  <h1 style='text-align:center'>Raport wybranych jazd</h2><table border=1><thead><tr>
            //  <td>Imię</td><td>Nazwisko</td><td>Data</td><td>Godzina rozpoczęcia</td>
            //  <td>Godzina zakończenia</td><td>Status</td></tr></thead>";
            $kursant_id=$request->get('kursant');
            $instruktor_id=$request->get('instruktor');
            $status_id=$request->get('status');
            $date=$request->get('data');
            $link=''; 

            if($kursant_id != '' ||  $instruktor_id != ''||  $status_id != '' || $date != '')
            {
                if($kursant_id==-1){
                    $jazdy = Ride::where('status_id', 'like', '%'.$status_id)
                    ->where('instructor', 'like','%'.$instruktor_id)               
                    ->where('date','like', '%'.$date)     
                    ->whereNull('student')
                    ->get();
                }
                elseif($kursant_id=='')
                {
                    $jazdy = Ride::where('status_id', 'like', '%'.$status_id)
                    ->where('instructor', 'like','%'.$instruktor_id)
                    ->where('date','like', '%'.$date)     
                    ->get();
                }
                else
                {
                    $jazdy = Ride::where('status_id', 'like', '%'.$status_id)
                    ->where('instructor', 'like','%'.$instruktor_id)
                    ->where('student','like', '%'.$kursant_id.'%')
                    ->where('date','like', '%'.$date)     
                    ->get();
                }
                
            }
            else{
                $jazdy=Ride::get();
            }       
                        
            // if($jazdy->count()==0){
            //     $output='<h2>Brak danych</h2>';
            // }
            // foreach($jazdy as $row)
            // {
            //     if($row->kursant==null){
            //         $output .= '
            //         <tr>
            //         <td>'.$row->instruktorr->name.'</td>
            //         <td>---</td>
              
            //         <td>'.$row->data.'</td>
            //         <td>'.$row->godz_rozp.'</td>
            //         <td>'.$row->godz_zak.'</td>
            //         <td>'.$row->status->name.'</td>
                 
            //     </tr>
            //     ';
            //     }else{
            //         $output .= '
            //         <tr>
            //         <td>'.$row->instruktorr->name.'</td>
            //         <td>'.$row->kursantt->name.'</td>
              
            //         <td>'.$row->data.'</td>
            //         <td>'.$row->godz_rozp.'</td>
            //         <td>'.$row->godz_zak.'</td>
            //         <td>'.$row->status->name.'</td>
                  
            //     </tr>
            //     ';
            //     }
                
            // }
            // $output.="</table></body></html>";
            // $suma=Jazdy::sum('ile_godz')->groupBy('status');
            $pdf=\App::make('dompdf.wrapper');
            $pdf->loadView('jazdy/export',compact('jazdy'));
            return $pdf->stream();   
        
    }



    public function mojeJazdy(){

        $id=Auth::id();
        $jazdy=Ride::where('instructor',$id)->get();
        //$instruktor=Jazdy::find(1)->instruktor;
        //$jazdy=App\User::find(1)->jazdy;
        return view('jazdy.mojeJazdyP',compact('jazdy'));
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output='';
            $kursant_id=$request->get('kursant');
            $instruktor_id=$request->get('instruktor');
            $status_id=$request->get('status');
            $date=$request->get('data');
            $link=''; 
            if($kursant_id != '' ||  $instruktor_id != ''||  $status_id != '' || $date != '')
            {
                if($kursant_id==-1){
                    $jazdy = Ride::where('status_id', 'like', '%'.$status_id)
                    ->where('instructor', 'like','%'.$instruktor_id)               
                    ->where('date','like', '%'.$date)     
                    ->whereNull('student')
                    ->get();
                }
                elseif($kursant_id=='')
                {
                    $jazdy = Jazdy::where('status_id', 'like', '%'.$status_id)
                    ->where('instructor', 'like','%'.$instruktor_id)
                    ->where('date','like', '%'.$date)     
                    ->get();
                }
                else
                {
                    $jazdy = Ride::where('status_id', 'like', '%'.$status_id)
                    ->where('instructor', 'like','%'.$instruktor_id)
                    ->where('student','like', '%'.$kursant_id)
                    ->where('date','like', '%'.$date)     
                    ->get();
                }
            }
            else{
                $jazdy=Ride::get();
            }                     
            if($jazdy->count()==0){
                $output='<h2 class="text-center">Brak danych</h2>';
            }
            foreach($jazdy as $row)
            {
                if($row->student==null){
                    $output .= '
                    <tr>
                    <td>'.$row->instruktorr->name.'</td>
                    <td>---</td>
                    <td>'.$row->date.'</td>
                    <td>'.$row->time_start.'</td>
                    <td>'.$row->time_stop.'</td>
                    <td>'.$row->status->name.'</td>
                </tr>
                ';
                }else{
                    $output .= '
                    <tr>
                    <td>'.$row->instruktorr->name.' '.$row->instruktorr->surname.'</td>
                    <td>'.$row->kursantt->name.' '.$row->kursantt->surname.'</td>
                    <td>'.$row->date.'</td>
                    <td>'.$row->time_start.'</td>
                    <td>'.$row->time_stop.'</td>
                    <td>'.$row->status->name.'</td>
                </tr>
                ';
                }
            }
            $jazdy = array(
                'table_data'    =>  $output,
                'link'  =>  $link
            );
            echo json_encode($jazdy);
        }
        
    }
}
