@extends('layouts.app')

@section('content')
    <h2 class="text-center">Dodaj kursanta do systemu</h2>
    @if($message = Session::get('success'))
      <div class="alert alert-success alert-block">
     
      <strong>{{ $message }}</strong>
      </div>

    @endif
    <form action="{{route('user.saveKursant')}}" method="post">
    <input name="_token" value="{{csrf_token()}}" type="hidden">
        
        <div class="form-group">
          <label for="">Imię</label>
          <input type="text" name="name" id="" class="form-control" placeholder="" pattern="[A-Za-zęółśążźćńĘÓŁŚĄŻŹĆŃ]{2,45}" aria-describedby="helpId" required>
          
        </div>
        @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            <label for="">Nazwisko</label>
            <input type="text" name="surname" id="" class="form-control" placeholder="" pattern="[A-Za-zęółśążźćńĘÓŁŚĄŻŹĆŃ]{2,45}" aria-describedby="helpId" required>
            
          </div>
          @error('surname')
      <div class="alert alert-danger">{{ $message }}</div>
          @enderror

          <div class="form-group">
              <label for="">Email</label>
              <input type="email" name="email" id="" class="form-control" placeholder="" aria-describedby="helpId" required>
              <small id="helpId" class="text-muted">Podaj email</small>
            </div>
            @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="">Telefon</label>
                <input type="tel" name="phone" id="" class="form-control"  aria-describedby="helpId"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}"
                required>
                <small id="helpId" class="text-muted">Numer telefonu w formacie: 999-999-999</small>
              </div>
              @error('phone')
          <div class="alert alert-danger">{{ $message }}</div>
              @enderror
        <button class="btn btn-primary">Zapisz</button>
    </form>
    <br>

@endsection

@section('title', 'Dodawanie uzytkownika')