@extends('layouts.layoutUser')

@section('content')

<style>
.playbutton{
    width: 47px;
    position: absolute;
    top: 28px;
    cursor: pointer;
    transition: 0.5s;
    left: 60px;
}
.viddiv{
    border:solid black 1px;padding:10px;text-align:center;
}
.viddiv img: hover .playbutton
{
    opacity: 1;
}
.modal-content{
    background: transparent !important;
    border: none !important;
}

</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @for ($i = 0; $i < count($video); $i++)
                <div class="card">
                    <div class="card-body">
                        <div class='row'> 
                            <div class="col-md-4" class="viddiv"> 
                                <img src="{{asset('/storage/images/'.$video[$i]->image)}}" width="150" height="100">
                                {{-- <img class="playimage" src="{{asset('/storage/watermark/'.$video[$i]->watermark)}}" width="140" height=90" ></img> --}}

                                <img class="playbutton" src="{{asset('play-button.png')}}" video="{{$video[$i]->video}}"
                                 demo="{{$i+1}}" >
                            </div>
                            <div class="col-md-8"> 
                                <h4>{{ $video[$i]->title}}</h4>
                                <span>{{$video[$i]->description}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>


                <div class="modal fade" id="{{$i+1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-body">
                            <video controls preload="auto"
                            width="100%">
                                <source class="vid" src="{{asset('/storage/'.$video[$i]->video)}}" type="video/mp4">
                                    <source src="MY_VIDEO.webm" type="video/webm" />
                                </video>     
                        </div>
                        </div>
                    </div>
                </div>



            @endfor
            @if(count($video)<=0)
                <div class="card">
                    <div class="card-body">
                        <div class='row'>
                           <h2 style="color:black;"> Admin Video Not Uploaded</h2>
                        </div>
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</div>

<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <video controls loop width="100%">
            <source class="vid" src="E:/Datta/videoDemo/videoTask/public/storage/video/Google Nest Mini - Hands-free entertainment.mp4" type="video/mp4">
        </video>      
      </div>
    </div>
  </div>
</div> -->
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
<script type="text/javascript">

    $(document).ready(function() {
        var mod;
        $('.playbutton').click(function(){
            mod = $(this).attr('demo');
             $('#'+mod).modal('show');
        });

        $('#'+mod).on('hidden.bs.modal', function () {
            $('#vid').stopVideo();
            console.log('payssed');
        })
    });
</script>

@endsection
