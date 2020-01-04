@extends('layouts.app')

@section('content')

<div class="row ">
    <div class="col-12">
        <h2 class='text-center'> Wszystkie jazdy</h2>
         <form action="{{route('jazdy.export')}}" method="get">
             <div class="row">
             <div class="form-group col-md-3 col-6">
               <label for="">Data</label>
               <input type="date" name="data" id="data-search" class="form-control" placeholder="" aria-describedby="helpId" value>
             </div>
            <div class="form-group col-md-3 col-6">
              <label for="kursant">Kursant</label>
              <select  class="form-control" name="kursant" id="kursant-search">
                <option value="">--</option>
                <option value="-1">Brak</option>
                @foreach ($kursanci as $kursant)
              <option value="{{$kursant->id}}"><span>{{$kursant->name}}</span> <span>{{$kursant->surname}}</span> </option>    
                @endforeach
              </select>
            </div>
             <div class="form-group col-md-3 col-6">
                 <label for="instruktor">Instruktor</label>
                 <select  class="form-control" name="instruktor" id="instruktor-search">
                   <option value="">---</option>
                   @foreach ($instruktor as $i)
                 <option value="{{$i->id}}"><span>{{$i->name}}</span> <span>{{$i->surname}}</span></option>    
                   @endforeach  
                 </select>
               </div>
               <div class="form-group col-md-2 col-6">
                     <label for="status">Status</label>
                     <select  class="form-control" name="status" id="status-search">
                       <option value="">---</option>
                       @foreach ($status as $i)
                     <option value="{{$i->id}}"><span>{{$i->name}}</span></option>    
                       @endforeach   
                     </select>
                   </div>
                   <div class="form-group col-md-1 col-4 text-center mx-auto ">
                     <label>Anuluj</label>
                   <a href="{{route('jazdy.wszystkieJazdy')}}"><button type="button" class="btn btn-danger"><i data-feather="x-circle"></i></button></a>
                   </div>
             <div class="form-group col-md-4 mx-auto text-center">
                 <button id="search" type="button" class="btn btn-primary"> Szukaj</button>
                 <button type="submit" id="export" class="btn btn-danger"> Eksportuj do PDF</button>
             </div>
 
             </div>
         </form>
     </div>
    
     <div class="table-responsive">
        
      
      <table class="table text-center">
          <thead class="font-weight-bold">
            <tr>
              <td>Instruktor</td>
              <td> Kursant</td>
              <td>Data</td>
              <td>Godzina rozpoczecia</td>
              <td>Godzina zakonczenia</td>
              <td>status</td>
              {{-- <td>Akcje</td> --}}
              {{-- <td>Anuluj</td>
              <td>Odbyła się</td>
              <td>Nie odbyła się</td> --}}
              </tr> 
          </thead>
          <tbody>
          @foreach($jazdy as $jazda)
          
          
          <tr>
              <td><span>{{$jazda->instruktorr->name}}</span> <span>{{$jazda->instruktorr->surname}}</span></td>
              <td>@if($jazda->student == null) ---
                  @else {{$jazda->kursantt->name}} {{$jazda->kursantt->surname}}
                  @endif
              </td>
              <td>{{$jazda->date}}</td>
              <td>{{$jazda->time_start}}</td>
              <td>{{$jazda->time_stop}}</td>
              <td>{{$jazda->status->name}}</td>
              {{-- <td> 
                  <a href="{{route('jazdy.edycja', $jazda)}}"><button type="button" class="btn btn-primary">Edycja</button> </a>
        
              </td> --}}
              {{-- @if($jazda->checkData() )
                    <td>
                         <button type="button" data-jazdy="{{$jazda}}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" 
                        title="Anuluj zaplanowaną jazdę"> <i data-feather="x-circle"></i></button>
                     </td>
                   
                    <td><button type="button" class="btn btn-secondary" disabled="disabled" ><i data-feather="check"></i></button> </td>  
                      
                    <td><button type="button" class="btn btn-secondary" disabled="disabled" ><i data-feather="frown"></i></button></td>
                    
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
                                 <i data-feather="frown"></i></button> 
                         </td>
        
                        
                  
                        @endif --}}
          </tr>
          @endforeach
          </tbody>
        
      </table>
     </div>
</div>
    

    
    
    
    <div id='link'>{!! $jazdy->links() !!}</div>
</div>
 <br>
</div>
@endsection

@section('script')
  
<script>
 $(document).ready(function() {

  $('#search').click(function(e){
    e.preventDefault;

    var day, month, year;
       var date =$('#data-search').val().split("-");
       day=date[2];
       month= date[1];
       year=date[0];
       if(day!='' && month!='' && year!=''){var d=[year,month,day].join('-');}
      var kursant = $('#kursant-search').children("option:selected").val();
      var instruktor = $('#instruktor-search').children("option:selected").val();
      var status = $('#status-search').children("option:selected").val();
      $.ajax({
            url:"{{ route('jazdy.search') }}",
            method: 'GET',
            data:{
              kursant:kursant,
              instruktor:instruktor,
              status:status,
              date:d
            },
            dataType:'json',
            success:function(jazdy)
            {
              $('tbody').html(jazdy.table_data);
              $('#link').html(jazdy.link);
            }
      })

  });
  

  // $( ".btn-danger" ).click(function(e) {
  //   e.preventDefault();
  //   let jazdy=$(this).data().jazdy;
  //   let id=jazdy.id;
  

  //             swal({
  //           title: "Czy na pewno chcesz anulowac tą jazdę?",
  //           text: "Tej operacji nie da się odwrócić ",
  //           icon: "warning",
  //           buttons: true,
  //          // dangerMode: true,
  //         })
  //         .then((willDelete) => {
  //           if (willDelete) {

  //             location.href = "anuluj/"+id;
  //           } else {
              
  //           }
  //         });
  //   });

  //   $( ".btn-success" ).click(function(e) {
  //   e.preventDefault();
  //   let jazdy=$(this).data().jazdy;
  //   let id=jazdy.id;
  

  //             swal({
  //           title: "Czy ta jazda zakończyła się pomyślnie?",
  //           text: "Oznacz po zakończonej jeździe",
  //           icon: "success",
  //           buttons: true,
  //          // dangerMode: true,
  //         })
  //         .then((willDelete) => {
  //           if (willDelete) {

  //             location.href = "ok/"+id;
  //           } else {
              
  //           }
  //         });
  //   });
  //   $( ".btn-warning" ).click(function(e) {
  //   e.preventDefault();
  //   let jazdy=$(this).data().jazdy;
  //   let id=jazdy.id;
  

  //             swal({
  //           title: "Czy ta jazda nie odbyła się planowo?",
  //           text: "Oznacz gdy upłyną termin zaplanowanej jazdy i jazda się nie odbyła",
  //           icon: "warning",
  //           buttons: true,
  //          // dangerMode: true,
  //         })
  //         .then((willDelete) => {
  //           if (willDelete) {

  //             location.href = "no/"+id;
  //           } else {
             
  //           }
  //         });
  //   });
  // $('#export').click(function(e){
    
  //   e.preventDefault;

  //   var day, month, year;
    
    
  //      var date =$('#data-search').val().split("-");
  //      day=date[2];
  //      month= date[1];
  //      year=date[0];
  //      if(day!='' && month!='' && year!=''){
  //       var d=[year,month,day].join('-');
  //       console.log(d);
  //   }

  //     var kursant = $('#kursant-search').children("option:selected").val();
  //     var instruktor = $('#instruktor-search').children("option:selected").val();
  //     var status = $('#status-search').children("option:selected").val();
    
   
  //     $.ajax({
  //           url:"{{ route('jazdy.export') }}",
  //           method: 'GET',
  //           data:{
  //             kursant:kursant,
  //             instruktor:instruktor,
  //             status:status,
  //             date:d
  //           },
  //           dataType:'json',
  //           success:function()
  //           {
  //             console.log("data");
  //           }

  //     })

  // });
})
feather.replace();
</script>

@endsection

@section('title', 'Wszystkie jazdy')