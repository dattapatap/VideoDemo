@extends('layouts.layoutAdmin')

@section('content')

        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-info">{{ __('Users List') }}</div>

                <div class="card-body">
                    <a href="{{ url('useradd') }}" class="btn btn-sm btn-info pull-right">Add User</a>
                    <br><br>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table class="table table-hover">
                        <thead>
                                <tr>
                                <th scope="col">Sl No</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                            @for ($i = 0; $i < count($users); $i++)
                                
                                <tr id ={{ $users[$i]->id }}>
                                    <th scope="row">{{$i+1}}</th>
                                    <td>{{ $users[$i]->first_name}}</td>
                                    <td>{{$users[$i]->last_name}}</td>
                                    <td>{{$users[$i]->email}}</td>
                                    <td> 
                                        <a class="btn btn-danger btn-xs" href="{{ url('deleteUser',[$users[$i]->id]) }}">{{ __('Delete') }}</a>
                                        
                                    </td>
                                </tr>

                            @endfor
                            @if(count($users)<=0)
                                <tr>
                                    <td colspan="5" style="text-align:center;">No User Available</td>
                                </tr>
                            @endif
                           </tbody>
                        </table>
                </div>
            </div>
        </div>
@endsection
