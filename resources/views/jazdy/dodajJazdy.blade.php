@extends('layouts.app')

@section('content')
    <h1 class="text-center">Dodaj termin jazdy</h1>
    @if($message = Session::get('success'))
      <div class="alert alert-success alert-block">
     
      <strong>{{ $message }}</strong>
      </div>

    @endif
    @if($message = Session::get('er'))
      <div class="alert alert-danger">
     
      <strong>{{ $message }}</strong>
      </div>

    @endif
    <form action="{{route('jazdy.saveJazdy')}}" method="post">
    <input name="_token" value="{{csrf_token()}}" type="hidden">
        <div class="form-group">
          <label for="">Data</label>
          <input type="date" name="data" id="data" class="form-control" placeholder="" max="2020-12-31" aria-describedby="helpId" required>
          <small id="helpId" class="text-muted">Podaj date planowanje jazdy</small>
        </div>
        @error('data')
    <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
          <label for="">Godzina rozpoczęcia jazdy</label>
          <input type="time" name="godz_rozp" id="godz_rozp" step="600" class="form-control" placeholder=""  aria-describedby="helpId" required>
          <small id="helpId" class="text-muted">Podaj godzine rozpoczecia</small>
        </div>
        @error('godz_rozp')
    <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
          <label for="ile">Jak długo będzie trwała jazda w (h)</label>
          <select class="form-control"  name="ile" id="ile" required>
          <option value="">---</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Godzina zakończenia jazdy</label>
          <input type="time" name="godz_zak" id="godz_zak"  class="form-control" placeholder="" aria-describedby="helpId" readonly required>
          <small id="helpId" class="text-muted">Podaj godzine zakończenia</small>
        </div>
        @error('godz_zak')
    <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
        <label for="kursant">Wybierz kursanta (opcjonalne)</label>
        <select  class="form-control" name="kursant" id="kursant"> 
            <option value="">---</option>
            @foreach($kursanci as $kursant)
            <option value="{{ $kursant->id}}" ><span>{{ $kursant->name}} </span> | <span>{{ $kursant->email}}</span></option>
            @endforeach
          </select>
          </div>
          @error('kursant')
    <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-primary">Dodaj</button>
    </form>
    <br>
    <a href="/mojeJazdy" >Pokaz moje jazdy</a>


@endsection


@section('script')

<script>
 let today = new Date().toISOString().slice(0, 10);
 console.log(today);

//let time = document.getElementById('godz_rozp').value;
//console.log(time);
 document.getElementById('data').min = today;
 document.getElementById('godz_rozp').min = '06:00';
 document.getElementById('godz_rozp').max = '20:00';
 //var x = document.getElementsByName("ile").value;
 //console.log(x);
 //var time = document.getElementById('godz_zak');

 $(document).ready(function() {
  


   
  $("#ile").change(function() {
      var x=$('#ile').val();
      var xx=parseFloat(x);
     var time = document.getElementById('godz_rozp').value;
     var t = time.replace(':','.');   
     var tim=parseFloat(t);
     tim=xx+tim;
     timm=parseFloat(tim).toFixed(2);
     var t2=String(timm);
     t = t2.replace('.',':');
     if(t.length==4){
      t=0+t;
     }
     document.getElementById('godz_zak').value = t;
    });

    $("#godz_rozp").change(function () {
      var x=$('#ile').val();
      var xx=parseFloat(x);
     var time = document.getElementById('godz_rozp').value;
     var t = time.replace(':','.');   
     var tim=parseFloat(t);
     tim=xx+tim;
     timm=parseFloat(tim).toFixed(2);
     var t2=String(timm);
     t = t2.replace('.',':');
     if(t.length==4){
      t=0+t;
     }
     document.getElementById('godz_zak').value = t;
    });

});
</script>

@endsection
@section('title', 'Dodawanie nowej jazdy')