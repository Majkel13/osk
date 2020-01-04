<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Raport</title>
    <style>
        table {border-collapse: collapse; text-align :center;}
        table, td, th {border: 1px solid black;padding: 10px;}
        h2{ text-align: center;}
        thead{font-weight: 800;}
        body {font-family: DejaVu Sans;}
        table.center {margin-left:auto;  margin-right:auto;}
    </style>
</head>
<body>
        <h2> Raport jazd kursanta:</h2>
        <div style="margin-left: 20px">    
            <b>Imię:</b> {{$kursant->name}}<br>
            <b>Nazwisko:</b> {{$kursant->surname}}<br>
            <b>Email:</b> {{$kursant->email}}<br>
        </div>
 <div>
    <table class="center">
    <thead>
        <tr><td>Jazda(status)</td>
            <td>Ilość godzin</td></tr>
    </thead>
    <tbody>
        <tr><td>Zaplanowana</td>
            <td>{{$ile_zaplanowane}}</td></tr>
        <tr><td>Odbyta</td>
            <td>{{$ile_odbyte}}</td></tr>
        <tr><td>Nieodbyta</td>
            <td>{{$ile_nieodbyte}}</td></tr>
        <tr><td>Dodatkowe</td>
            <td>{{$ile_dodatkowe}}</td></tr>
    </tbody>
</table>
</div>



</body>
</html>