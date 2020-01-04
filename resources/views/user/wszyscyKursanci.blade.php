@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <h2 class='text-center'> Wszyscy kursanci</h2>
        <div class="table-responsive text-center">
        <table class="table">
            <thead class="font-weight-bold">
            <tr>
                <td>Imie</td>
                <td>Nazwisko</td>
                <td>Email</td>
                <td>Telefon</td>
                <td>Edycja</td>
                
                </tr> 
            </thead>
            
            @foreach($users as $user)
            
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->surname}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone}}</td>
                <td>
                    <a href="{{route('user.edycja', $user)}}"><button type="button" class="btn btn-primary">Edycja</button></a> 
                
                    
                </td>
            </tr>
            @endforeach
        </table>
        {!! $users->links() !!}  
        </div>
    </div>
</div>

    
    
 <br>


    
@endsection


@section('title', 'Wszyscy uzytkownicy')