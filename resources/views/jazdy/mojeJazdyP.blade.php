@extends('layouts.app')

@section('content')

    <div class="row">
      <div class="col-12">
          @if($message = Session::get('er'))
          <div class="alert alert-success">
         
          <strong>{{ $message }}</strong>
          </div>
      
        @endif
        @if($message = Session::get('er2'))
          <div class="alert alert-danger">
         
          <strong>{{ $message }}</strong>
          </div>
      
        @endif
          <h2 class='text-center'> Moje jazdy</h2>


        <div class="table-responsive pt-2">
            <table class="table text-center">
                <thead>
                   <tr class="font-weight-bold ">
                    
                    <td> Kursant</td>
                    <td>Data</td>
                    <td>Godzina rozpoczecia</td>
                    <td>Godzina zakonczenia</td>
                    <td>Status</td>
                    <td >Anuluj</td>
                    <td>Odbyła się </td>
                   <td>Nie odbyła się </td>
                    </tr> 
                </thead>
        
                @foreach($jazdy as $jazda)
                
                <tr>
                    
                    <td>@if($jazda->student == null) ---
                        @else {{$jazda->kursantt->name}} {{$jazda->kursantt->surname}}
                        @endif
                    </td>
                    <td>{{$jazda->date}}</td>
                    <td>{{$jazda->time_start}}</td>
                    <td>{{$jazda->time_stop}}</td>
                    <td>{{$jazda->status->name}}</td>
                    @if($jazda->checkData() )
                    <td>
                         <button type="button" data-jazdy="{{$jazda}}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" 
                        title="Anuluj zaplanowaną jazdę"> <i data-feather="x-circle"></i></button>
                     </td>
                   
                    <td><button type="button" class="btn btn-secondary" disabled="disabled" ><i data-feather="check"></i></button> </td>  
                      
                    <td><button type="button" class="btn btn-secondary" disabled="disabled" ><i data-feather="slash"></i></button></td>
                    
                        @else 
                        <td><button type="button" class="btn btn-secondary" disabled="disabled" ><i data-feather="x-circle"></i></button></td>
                        <td>
                            @if($jazda->checkStatus('wolna'))
                            <button type="button" class="btn btn-secondary" disabled="disabled"><i data-feather="check"></i></button>
                            @else  
        
                             <button type="button" data-jazdy="{{$jazda}}"  class="btn btn-success" data-toggle="tooltip" data-placement="top" 
                                title="Oznacz gdy jazda się już odbył"><i data-feather="check"></i></button>
                            @endif
                        </td>
                        <td>
                           <button type="button" data-jazdy="{{$jazda}}" class="btn btn-warning"
                                 data-toggle="tooltip" data-placement="top" title="Oznacz gdy jazda nie odbyła się a termin już minął">
                                 <i data-feather="slash"></i></button> 
                         </td>
        
                        
                  
                        @endif
                
                </tr>
                @endforeach
            </table>
            {!! $jazdy->links() !!}
        </div>
      </div>
    </div>

  
  
 <br>

@endsection
@section('script')

<script>


 $(document).ready(function() {
 
    $(".tooltip").tooltip();

    $( ".btn-danger" ).click(function(e) {
    e.preventDefault();
    let jazdy=$(this).data().jazdy;
    let id=jazdy.id;
  

              swal({
            title: "Czy na pewno chcesz anulowac tą jazdę?",
            text: "Tej operacji nie da się odwrócić ",
            icon: "warning",
            buttons: ["Nie", "Tak"],
           // dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {

              location.href = "anuluj/"+id;
            } else {
              
            }
          });
    });

    $( ".btn-success" ).click(function(e) {
    e.preventDefault();
    let jazdy=$(this).data().jazdy;
    let id=jazdy.id;
  

              swal({
            title: "Czy ta jazda zakończyła się pomyślnie?",
            text: "Oznacz po zakończonej jeździe",
            icon: "success",
            buttons: ["Anuluj", "Tak"],
           // dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {

              location.href = "ok/"+id;
            } else {
              
            }
          });
    });
    $( ".btn-warning" ).click(function(e) {
    e.preventDefault();
    let jazdy=$(this).data().jazdy;
    let id=jazdy.id;
  

              swal({
            title: "Czy ta jazda nie odbyła się planowo?",
            text: "Oznacz gdy upłyną termin zaplanowanej jazdy i jazda się nie odbyła",
            icon: "warning",
            buttons: ["Anuluj", "Tak"],
           // dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {

              location.href = "no/"+id;
            } else {
             
            }
          });
    });
})

  feather.replace();

</script>

@endsection

@section('title', 'Moje jazdy')