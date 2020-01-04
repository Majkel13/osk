@extends('layouts.app')

@section('content')
<div class="row">
        <div class=" col-12 text-center"><h1>Witaj  <strong>{{ Auth::user()->name }}</strong> w naszej aplikacji</h1></div>
        
        <div class="col-12 text-center">
             <img  src="auto.png" class="img-fluid" alt="Auto" >
             <div class="p-3 text-justify">
                {{-- <h2 class="text-center">Informacje dla użytkowników</h2>
               <p> Drogi kursancie aby zapisać się na jazde wejdź w zakładke "wolne terminy" i kliknij
                zapisz się a następnie zatwierdź. Informacje o wszystkich swoich jazdach zdobędziesz w 
                zakładce "Moje jazdy" tam też możesz anulować swoją planowaną jazdę ale uwaga <b>najpóźniej 
                dwa dni</b> przed planowanym szkoleniu, dlatego przemyśl czy wybrany termin ci odpowiada.</p>
                <p>    Informujemy również że w ramach wykupionego kursu możesz się zapisać na 30h jazd wszystkie 
                dodatkowe jazdy są dodatkowo płatne.</p> --}}
               

             </div>
         </div>
          
    </div>

        

@endsection
