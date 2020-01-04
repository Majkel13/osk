<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Raport</title>
    <style>
        table {
        border-collapse: collapse;
        text-align :center;
        }

        table, td, th {
        border: 1px solid black;
        padding: 10px;
        }
        h2{
            text-align: center;
        }
        h3{
            text-align: center;
        }
        thead{
            font-weight: 800;
        }
        body {
        font-family: DejaVu Sans;
        }
        table.center {
    margin-left:auto; 
    margin-right:auto;
  }
  div{
      margin-left: 20px;
  }
        
    </style>
</head>
<body>
        <div>    <h3>
    @if ($instruktor!=null)
       Raport jazd instruktora:</h3>
       <div style="margin-left:20px">
          <b>Imię:</b>  {{$instruktor->name}}<br>
          <b>Nazwisko:</b>   {{$instruktor->surname}}<br>
          <b>Email:</b>  {{$instruktor->email}}
       </div>
    @else
       <h3> Raport jazd wszytkich instruktorów</h3>
    @endif
<br>
    <div>
        @if($data_start!=null)
        od {{$data_start}}
        @endif

        @if($data_stop!=null)
        do {{$data_stop}}
        @endif
        
    </div>



 <div>
    <table class="center">
    <thead>
        <tr>
            <td>Jazda(status)</td>
            <td>Ilość w h</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Zaplanowana</td>
        <td>{{$ile_zapolanowane}}</td>
        </tr>
        <tr>
            <td>Wolna</td>
        <td>{{$ile_wolne}}</td>
        </tr>
        <tr>
            <td>Odbyta</td>
        <td>{{$ile_odbyte}}</td>
        </tr>
        <tr>
            <td>Nie odbyta</td>
        <td>{{$ile_nieOdbyte}}</td>
        </tr>
        <tr>
            <td>Anulowana</td>
        <td>{{$ile_anulowane}}</td>
        </tr>
        <tr>
            <td>Wszystkie</td>
        <td>{{$ile_wszystkie}}</td>
        </tr>
    </tbody>
</table>
</div>



</body>
</html>