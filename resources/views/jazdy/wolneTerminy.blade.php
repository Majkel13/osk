@extends('layouts.app')

@section('content')


    <div class="row">
      <div class="col-12">
          <h2 class='text-center'> Wolne  terminy</h2>
      </div>
     
      
      <div class="col-12 ">
     
            @if($message = Session::get('er'))
            <div class="alert alert-success">
          
            <strong>{{ $message }}</strong>
            </div>
            @endif

            @if($message = Session::get('er3'))
            <div class="alert alert-warning">
          
            <strong>{{ $message }}</strong>
            </div>
          @endif

          @if($message = Session::get('er2'))
            <div class="alert alert-danger">
          
            <strong>{{ $message }}</strong>
            </div>

          @endif

          <div class="table-responsive">
              <table class="table text-center">
                  <thead class="font-weight-bold">
                    <tr>
                      <td>Instruktor</td>
                      <td>Data</td>
                      <td>Godzina rozpoczecia</td>
                      <td>Godzina zakonczenia</td>
                      <td>Akcje</td>
                      </tr> 
                  </thead>
                  @foreach($jazdy as $jazda)
                  @if($jazda->checkData() )
                  <tr>
                      <td>{{$jazda->instruktorr->name}} {{$jazda->instruktorr->surname}}</td>
                      <td>{{$jazda->date}}</td>
                      <td>{{$jazda->time_start}}</td>
                      <td>{{$jazda->time_stop}}</td>
                      <td>
                    <button data-jazdy="{{$jazda}}" type="button" class="btn btn-primary">zapisz sie</button> 
                      </td>
                  </tr>
                  @else
                  @endif
                  @endforeach
              </table>
          </div>
      </div>

    </div>

 <br>

@endsection

@section('script')
1


<script>

$(document).ready(function(){
  

  $( ".btn-primary" ).click(function(e) {
    e.preventDefault();
    var jazdy=$(this).data().jazdy;
    var id=jazdy.id;
              swal({
            title: "Czy chcesz sie zapisac na jazdy?",
            text: "Kliknięcie ok spowoduje próbę zapisania na jazdy w danym terminie ",
            icon: "success",       
            buttons: ["Anuluj", "Zapisz"],
          })
          .then((willDelete) => {
            if (willDelete) {
              location.href = "save/"+id;
            } else {
              swal("Anulowano zapisanie");
            }
          });
    });

});

</script>
@endsection

@section('title', 'wolne terminy')