@extends('layouts.app')

@section('content')
    <h2 class="text-center">Raport ilości przepracowanych godzin instruktorów</h2>
    @if($message = Session::get('success'))
      <div class="alert alert-success alert-block">
     
      <strong>{{ $message }}</strong>
      </div>

    @endif
    <form action="{{route('user.exportRaport')}}" method="get">
    <input name="_token" value="{{csrf_token()}}" type="hidden">
    <div class="form-group">
        <label for="">Data od</label>
        <input type="date" name="data_start" id="data-start" class="form-control" placeholder="" aria-describedby="helpId" value >
        </div>

      <div class="form-group">
        <label for="">Data do</label>
        <input type="date" name="data_stop" id="data_stop" class="form-control" placeholder="" aria-describedby="helpId" value >
        </div>


        <div class="form-group">
            <label for="instruktor">Instruktor</label>
            <select  class="form-control" name="instruktor" id="instruktor">
              <option value="-1">Wszyscy</option>
              @foreach ($instruktor as $i)
            <option value="{{$i->id}}"><span>{{$i->name}}</span> <span>{{$i->surname}}</span></option>    
              @endforeach  
              
              
            </select>
          </div>
  

        
        <button class="btn btn-danger">Generuj raport</button>
    </form>
    <br>
    <h2 class="text-center">Raport ilości godzin danego kursanta</h2>
    @if($message = Session::get('success'))
      <div class="alert alert-success alert-block">
     
      <strong>{{ $message }}</strong>
      </div>

    @endif
    <form action="{{route('user.exportRaportKursant')}}" method="get">
    <input name="_token" value="{{csrf_token()}}" type="hidden">
        <div class="form-group">
            <label for="kursant">Wybierz kurasanta</label>
            <select  class="form-control" name="kursant" id="kursant" required>
              <option value="">---</option>
              @foreach ($kursant as $i)
            <option value="{{$i->id}}"><span>{{$i->name}}</span> <span>{{$i->surname}}</span></option>    
              @endforeach  
            </select>
          </div>
        <button class="btn btn-danger">Generuj raport</button>
    </form>
@endsection

@section('title', 'Raporty')