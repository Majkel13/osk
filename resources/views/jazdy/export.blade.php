<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eksport jazd</title>
    <style>
        table {
        border-collapse: collapse;
        text-align :center;
        }

        table, td, th {
        border: 1px solid black;
        }
        h2{
            text-align: center;
        }
        
        body {
        font-family: DejaVu Sans;
        }
    </style>
</head>
<body>
    <h2>Informację o wybranych jazdach</h2>
    @if($jazdy->count()==0)
    <p>Brak danych</p>
    @else
    <table>
        <thead style="font-size:20px">
            <tr>
                    <td>Instruktor</td>
                    <td>Kursant</td>
                    <td>Data</td>
                    <td>Godzina rozpoczecia</td>
                    <td>Godzina zakonczenia</td>
                    <td>status</td>
            </tr>
            @foreach($jazdy as $jazda)
          
          <tbody >
            <tr>
                <td>{{$jazda->instruktorr->name}}</td>
                <td>@if($jazda->student == null) ---
                    @else {{$jazda->kursantt->name}}
                    @endif
                </td>
                <td>{{$jazda->date}}</td>
                <td>{{$jazda->time_start}}</td>
                <td>{{$jazda->time_stop}}</td>
                <td>{{$jazda->status->name}}</td>
          
            </tr>
            @endforeach
            </tbody>
        </thead>
    </table>
    <br>
    @endif
</body>
</html>