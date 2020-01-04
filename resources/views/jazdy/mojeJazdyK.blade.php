@extends('layouts.app')

@section('content')
@if(Auth::user()->isAdministrator())
<div></div>
@endif
   
    
    <div class="row">
        <div class="col-12">
            <div class="py-4 mb-4">
                <h2 class="text-center mb-0"> Pasek postępu</h2>
                <p class="text-center" style="margin-top: -6px">Jazdy podstawowe</p>
                <div class="row">
                    <div class="col-12  py-4">
                        <div class="progress" style="height:30px;">
                             <div class="progress-bar progress-bar-striped bg-success"   role="progressbar" style="width: {{$procent_odbyte}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> {{$ile_odbyte}}h </div>
                             <div class="progress-bar  progress-bar-striped" role="progressbar" style="width: {{$procent_zaplanowany}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$ile_zaplanowane}}h</div>
                             <div class="progress-bar  progress-bar-striped bg-danger" role="progressbar" style="width: {{$procent_nieodbyte}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$ile_nieodbyte}}h</div>
                         </div>
                    </div>
                    
                    <div class="col-md-8 col-xl-6 pb-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="progress"> 
                                <div class="progress-bar progress-bar-striped bg-success"   role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            Jazdy odbyte
                            </div>
                            <div class="col-4"> 
                                    <div class="progress"> 
                                            <div class="progress-bar progress-bar-striped"   role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        Jazdy zaplanowane
                            </div>
                            <div class="col-4">
                                    <div class="progress"> 
                                            <div class="progress-bar progress-bar-striped bg-danger"   role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        Jazdy do końca kursu
                            </div>          
                        </div>            
                    </div>
                    <div class="col-12">
                           <h4 class="mb-0"> Jazdy dodatkowe: {{$ile_dodatkowe}}h</h4>
                           {{-- <p style="margin-top: -8px"> (zaplanowane, odbyte)</p> --}}
                    </div>
                </div>
            </div>               
        </div>
            
    </div>
    <h2 class='text-center'>Kalendarz Jazd</h2>
    @if($message = Session::get('er2'))
    <div class="alert alert-danger">
   
    <strong>{{ $message }}</strong>
    </div>

  @endif
    <div class="row "> 
        <div class=" col-12 ">
            <div class="table-responsive">
                    <table class="table text-center ">
                            <thead>
                            <tr class="font-weight-bold ">
                                <td>Instruktor</td>                                
                                <td>Data</td>
                                <td>Godzina rozpoczecia</td>
                                <td>Godzina zakonczenia</td>
                                <td>Status</td>    
                                <td></td> 
                                </tr> 
                            </thead>
            
                            @foreach($jazdy as $jazda)
                            
                            @if ($jazda->status->name=='odbyta')
                            <tr class="table-success">
                                <td class="instruktor" style="cursor: pointer;"  data-toggle="tooltip" title="Klinkj aby zobaczyć szczegóły instruktora"
                                data-instruktor="{{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}} {{$jazda->instruktorr->email}} {{$jazda->instruktorr->phone}}">
                                    {{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}}</td>
                                
                                <td>{{$jazda->date}}</td>
                                <td>{{$jazda->time_start}}</td>
                                <td>{{$jazda->time_stop}}</td>
                                <td>{{$jazda->status->name}}</td>
                                <td></td>
                            </tr>
                            @elseif($jazda->status->name=='anulowana') 
                            <tr class="table-danger">
                                <td class="instruktor" style="cursor: pointer;"  data-toggle="tooltip" title="Klinkj aby zobaczyć szczegóły instruktora"
                                data-instruktor="{{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}} {{$jazda->instruktorr->email}} {{$jazda->instruktorr->phone}}">
                                    {{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}}</td>
                                
                                <td>{{$jazda->date}}</td>
                                <td>{{$jazda->time_start}}</td>
                                <td>{{$jazda->time_stop}}</td>
                                <td>{{$jazda->status->name}}</td>
                                <td></td>
                            </tr>
                            @elseif($jazda->status->name=='zaplanowana')
                            @if ($jazda->checkDataStudent())
                            <tr class="table-primary">
                                <td class="instruktor" style="cursor: pointer;"  data-toggle="tooltip" title="Klinkj aby zobaczyć szczegóły instruktora"
                                data-instruktor="{{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}} {{$jazda->instruktorr->email}} {{$jazda->instruktorr->phone}}">
                                    {{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}}</td>
                                
                                <td>{{$jazda->date}}</td>
                                <td>{{$jazda->time_start}}</td>
                                <td>{{$jazda->time_stop}}</td>
                                <td>{{$jazda->status->name}}</td>
                                <td>@if(!Auth::user()->isAdministrator())
                                    <button type="button" class="btn btn-danger" data-jazdy="{{$jazda}}" data-toggle="tooltip" data-placement="top" 
                                    title="Zrezygnuj z tej jazdy"><i data-feather="x-circle"></i></button>
                                     @endif
                                </td>
                            </tr>
                            @else
                            <tr class="table-primary">
                                <td class="instruktor" style="cursor: pointer;"  data-toggle="tooltip" title="Klinkj aby zobaczyć szczegóły instruktora"
                                data-instruktor="{{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}} {{$jazda->instruktorr->email}} {{$jazda->instruktorr->phone}}">
                                    {{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}}</td>
                                
                                <td>{{$jazda->date}}</td>
                                <td>{{$jazda->time_start}}</td>
                                <td>{{$jazda->time_stop}}</td>
                                <td>{{$jazda->status->name}}</td>
                                <td>@if(!Auth::user()->isAdministrator())
                                    <button type="button" class="btn btn-secondary" disabled="disabled" data-toggle="tooltip" data-placement="top" 
                                    title="Nie możesz już zrezygnować z tej jazdy"><i data-feather="x-circle"></i></button>
                                @endif
                                </td>
                            </tr>
                            @endif
                            
                            @elseif($jazda->status->name=='nieodbyta')
                            <tr class="table-warning">
                                <td class="instruktor" style="cursor: pointer;" data-toggle="tooltip" title="Klinkj aby zobaczyć szczegóły instruktora"
                                data-instruktor="{{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}} {{$jazda->instruktorr->email}} {{$jazda->instruktorr->phone}}">
                                    {{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}}</td>
                                
                                <td>{{$jazda->date}}</td>
                                <td>{{$jazda->time_start}}</td>
                                <td>{{$jazda->time_stop}}</td>
                                <td>{{$jazda->status->name}}</td>
                                <td></td>
                            </tr>
                            @endif     
                        @endforeach
                    </table>
            </div>
        </div>
    </div> 
 <br>

@endsection

@section('script')

    <script>

        $(document).ready(function(){

            if({{$ile_odbyte}}!=null){
              if({{$ile_odbyte}}>=30){
                swal({
                    title:'Gratulacje !!!',
                    text: 'Wyjeździłeś już wymaganą ilość godzin zapraszamy do zapisania się na egzamin w naszym biurze. '
                });
            }  
            }
            

            $(".tooltip").tooltip();

            $('.instruktor').click(function(e){
                
                e.preventDefault;
                var instruktor = $(this).data().instruktor;
                var div = document.createElement("div");
                div.innerHTML = "<div class='text-center'>"+instruktor+"</div>";
                console.log(instruktor);
                swal({
                    title:'Informacje o instruktorze',
                    content: div,
                });
            });

            $( ".btn-danger" ).click(function(e) {
    e.preventDefault();
    let jazdy=$(this).data().jazdy;
    let id=jazdy.id;
  

              swal({
            title: "Czy na pewno chcesz zrezygnować z tej jazdy?",
            text: "Tej operacji nie da się odwrócić ",
            icon: "warning",
            buttons: ["Nie", "Tak"],
           // dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {

              location.href = "zrezygnuj/"+id;
            } else {
              
            }
          });
    });

        })
        feather.replace();
    </script>
@endsection
@section('title', 'Moje jazdy')