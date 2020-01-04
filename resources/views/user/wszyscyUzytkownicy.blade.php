@extends('layouts.app')

@section('content')
{{-- @if(Auth::user()->isAdministrator()) --}}
<div class="row">
    <div class="col-12">
            <h2 class='text-center'> Wszyscy użytkownicy</h2>
            <form>
                <div class="row">
                    <div class="form-group col-md-2">
                    <label for="name-search">Imię</label>
                    <input type="text" name="" id="name-search" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                            <label for="surname-search">Nazwisko</label>
                            <input type="text" name="" id="surname-search" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                            <label for="email-search">Email</label>
                            <input type="email" name="" id="email-search" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                            <label for="phone-search">Telefon</label>
                            <input type="text" name="" id="phone-search" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                    <label for="role-search">Rola</label>
                    <select  class="form-control" name="" id="role-search">
                        <option value="">--</option>
                        
                        @foreach ($role as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>    
                        @endforeach
                        
                    </select>
                    </div> 
                    <div class="fomr-group col-md-2">
                        <label for="active-search">Aktywność</label>
                        <select class="form-control" name="" id='active-search'>
                            <option value="1">Aktywny</option>
                            <option value="0">Nieaktywny</option>
                            <option value="-1">Wszyscy</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 mx-auto text-center">
                      <label for="" ></label>
                      <button type="button" id="search" class="btn btn-primary">Szukaj</button>
                    </div>
                </div>
                
            </form>

            <div class="table-responsive">
                    <table class="table text-center">
                            <thead class="font-weight-bold">
                               <tr>
                                <td>Imie</td>
                                <td>Nazwisko</td>
                                <td>Email</td>
                                <td>Telefon</td>
                                <td>Rola</td>
                                <td>Aktywny</td>
                                <td>Edycja</td>
                                <td>Info</td>
                                </tr> 
                            </thead>
                            
                            <tbody>
                            @foreach($users as $user)
                            @if($user->role->name=='Kursant')
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->surname}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->role->name}}</td>
                                <td>
                                    @if ($user->active)
                                        <div class="form-check"><input class="form-check-input  mx-auto" type="checkbox" id="" value="" checked disabled></div>
                                    @else
                                        <div class="form-check"><input class="form-check-input mx-auto" type="checkbox" id="" value=""  disabled></div>
                                    @endif
                                </td>
                                <td>
                                     <a href="{{route('user.edycjaa', $user)}}"><button type="button" class="btn btn-primary">Edycja</button></a> 
                                </td>
                                <td>
                                    <a href="{{route('user.info',$user)}}"><button type="button" class="btn btn-success">Info</button></a>
                                </td>
                            </tr>
                            @else
                            <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->surname}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->role->name}}</td>
                                    <td>
                                        @if ($user->active)
                                            <div class="form-check"><input class="form-check-input  mx-auto" type="checkbox" id="" value="" checked disabled></div>
                                        @else
                                            <div class="form-check"><input class="form-check-input mx-auto" type="checkbox" id="" value=""  disabled></div>
                                        @endif
                                    </td>
                                    <td>
                                         <a href="{{route('user.edycjaa', $user)}}"><button type="button" class="btn btn-primary">Edycja</button></a> 
                                    </td>
                                    <td>--</td>
                                </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                       <div id="link">  {!! $users->links() !!}</div>
            </div>
    </div>
</div>

    
   
   
 <br>


{{-- <h2 class='text-center'> Admini</h2>
    <table class="table table-responsive">
        <thead class="font-weight-bold">
           <tr>
            <td>Imie</td>
            <td>Nazwisko</td>
            <td>Email</td>
            <td>Telefon</td>
            <td>Rola</td>
            <td>Akcja</td>
            </tr> 
        </thead>
        
        @foreach($users as $user)
        
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->surname}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->phone}}</td>
            <td>{{$user->role->name}}</td>
            <td><button type="button" class="btn btn-primary">Edycja</button> </td>
        </tr>
        @endforeach
    </table>
 <br>
<h2 class='text-center'> Pracownicy</h2>

    <table class="table table-responsive mx-auto ">
        <thead class="font-weight-bold">
           <tr>
                <td>Imie</td>
                <td>Nazwisko</td>
                <td>Email</td>
                <td>Telefon</td>
                <td>Rola</td>
                <td>Akcja</td>
            </tr> 
        </thead>
        
        @foreach($users1->hasRole('2') as $user)
        
        <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->surname}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone}}</td>
                <td>{{$user->role->name}}</td>
                <td><button type="button" class="btn btn-primary">Edycja</button> </td>
        </tr>
        @endforeach
    </table>

    <br>

    @endif
<h2 class='text-center'> Kursanci</h2>
    <table class="table table-responsive">
        <thead class="font-weight-bold">
           <tr>
                <td>Imie</td>
                <td>Nazwisko</td>
                <td>Email</td>
                <td>Telefon</td>
                <td>Rola</td>
                <td>Akcja</td>
            </tr> 
        </thead>
        
        @foreach($users1->hasRole('3') as $user)
        
        <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->surname}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone}}</td>
                <td>{{$user->role->name}}</td>
                <td><button type="button" class="btn btn-primary">Edycja</button> </td>
        </tr>
        @endforeach
    </table> --}}
    
    
@endsection

@section('script')
<script>
    $(document).ready(function(){

        $('#search').click(function(e){
            e.preventDefault;

            var name = $('#name-search').val();
            var surname = $('#surname-search').val();
            var phone = $('#phone-search').val();
            var email = $('#email-search').val();
            var role = $('#role-search').children("option:selected").val();
            var active = $('#active-search').children("option:selected").val();
            console.log(role);

            $.ajax({
                url: "{{ route('user.search') }}",
                method: 'GET',
                data:{
                    name: name,
                    surname: surname,
                    phone: phone,
                    email: email,
                    role: role,
                    active: active
                },
                dataType: 'json',
                success:function(users)
                {
                    $('tbody').html(users.table_data);
                    $('#link').html(users.link);
                }
            })
        });

    })
</script>    
@endsection
@section('title', 'Wszyscy uzytkownicy')