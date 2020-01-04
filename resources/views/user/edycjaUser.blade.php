@extends('layouts.app')

@section('content')
    <h1>Edytuj użytkownika</h1>
    @if($message = Session::get('success'))
      <div class="alert alert-success alert-block">
     
      <strong>{{ $message }}</strong>
      </div>

    @endif
    <form action="{{route('user.saveEdit2')}}" method="post">
    <input name="_token" value="{{csrf_token()}}" type="hidden">
    <input name="id" value="{{$user->id}}" type="hidden">
    <input name="lastEmail" value="{{$user->email}}" type="hidden">
               <div class="form-group">
          <label for="">Imię</label>
          <input type="text" name="name" id="" value="{{$user->name}}" class="form-control" placeholder="" aria-describedby="helpId" required>
          <small id="helpId" class="text-muted">Podaj imię</small>
        </div>
        @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            <label for="">Nazwisko</label>
            <input type="text" name="surname" id="" value="{{$user->surname}}" class="form-control" placeholder="" aria-describedby="helpId" required>
            <small id="helpId" class="text-muted">Podaj nazwisko</small>
          </div>
          @error('surname')
      <div class="alert alert-danger">{{ $message }}</div>
          @enderror

          <div class="form-group">
              <label for="">Email</label>
              <input type="email" name="email" id="" value="{{$user->email}}" class="form-control" placeholder="" aria-describedby="helpId" required>
              <small id="helpId" class="text-muted">Podaj email</small>
            </div>
            @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="">Telefon</label>
                <input type="tel" name="phone" id="" value="{{$user->phone}}" class="form-control" placeholder="" aria-describedby="helpId"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}"
                required>
                <small id="helpId" class="text-muted">Podaj numer telefonu Format: 123-456-789</small>
              </div>
              @error('phone')
          <div class="alert alert-danger">{{ $message }}</div>
              @enderror
        <div class="form-group"> 
          <label form="active">Aktywny</label>
          <select class="form-control" name="active" id='active'>
            
            <option value="0">Nie</option>
            <option value="1">Tak</option>
          </select>
        </div>
        <div class="form-group">
          <label for="role">Wybierz role</label>
          
          <select  class="form-control" name="role_id" id="role" required> 
           
          <option value="{{$user->role->id}}">{{$user->role->name}}</option>
            @foreach($roles as $role)
            <option value="{{ $role->id}}" >{{ $role->name}}</option>
            @endforeach
           
           
          </select>
          @error('role_id')
          <div class="alert alert-danger">{{ $message }}</div>
              @enderror
        </div>
        <button class="btn btn-primary">Zapisz</button>
    </form>
    <br>
   
@endsection

@section('title', 'Edytuj uzytkownika')