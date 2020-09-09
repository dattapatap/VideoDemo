@extends('layouts.layoutAdmin')

@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-info">{{ __('Video List') }}</div>
                @if (session('status'))
                        <!-- <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div> -->
                @endif
                <div class="card-body">
                    <a href="{{ url('videoadd') }}" class="btn btn-sm btn-info pull-right">Add Video</a>
                    <br><br>
                    <table class="table table-hover">
                        <thead>
                                <tr>
                                <th scope="col">Sl No</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Image</th>
                                <th scope="col"> Watermark </th>
                                <th scope="col"> Video </th>
                                </tr>
                            </thead>
                            <tbody>
                            @for ($i = 0; $i < count($video); $i++)
                                
                                <tr>
                                    <th scope="row">{{$i+1}}</th>
                                    <td>{{ $video[$i]->title}}</td>
                                    <td>{{$video[$i]->description}}</td>
                                    <td><img class="playimage" src="{{asset('/storage/images/'.$video[$i]->image)}}" width="60" height="40" ></img></td>
                                    <td> <img class="playimage" src="{{asset('/storage/watermark/'.$video[$i]->watermark)}}" width="60" height="40" ></img></td>
                                    <td>{{$video[$i]->video}}</td>
                                    <td> 
                                        <a class="btn btn-danger btn-xs" href="{{ url('deleteVideo',[$video[$i]->id]) }}">{{ __('Delete') }}</a>
                                        
                                    </td>
                                </tr>

                            @endfor
                            @if(count($video)<=0)
                                <tr>
                                    <td colspan="5" style="text-align:center;">No Videos Uploaded</td>
                                </tr>
                            @endif
                          
                           </tbody>
                        </table>
                </div>
            </div>
        </div>
@endsection
