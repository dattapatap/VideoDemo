<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use FFMpeg\Filters\Video\VideoFilters ;
use App\Http\Controllers\BackgroundProcess;
use Intervention\Image\ImageManagerStatic as Image;


use Redirect;
use App\Video;
use FFMpeg;
use File;

class VideoController extends Controller
{
    public function getAllVideo(){
        $video = Video::all();
        return view('admin.videoList',compact('video',$video));
    }

    public function getVideoForm(){
        return view('admin.addVideos');
    }
  
    public function store(Request $request){

        $data = $request->validate([
            'title' => ['required', 'string', 'max:10'],
            'description' => ['required', 'string', 'min:10'],
            'image' => ['required', 'image'],
            'watermark' => ['required', 'image'],
            'video' => ['required', 'mimes:mp4,webm,flv,avi,wmv|max:1000|required'],
        ],
        [
            'title.required' => 'Title must not be empty!',
            'title.max' => 'The maximun length of The Title is  :max',
            'description.required' => 'Description must be not empty',
            'description.min' => 'Description min length greater than 10!',
            'image.required' => 'Please select Image!',
            'image.image' => 'File type should be Image',
            'watermark.required' => 'Please select Image!',
            'watermark.image' => 'File type should be Image',
            'video.required' => 'video required',
            'video.mimes' => 'video should be mp4, webm, wmv format',
            'video.max' => 'video max length shold be less than 1000 kb'
        ]);
        try{
            if($request->hasFile('image') && $request->hasFile('watermark') && $request->hasFile('video')){

                $image= $request->image->getClientOriginalName();
                $watermark = $request->watermark->getClientOriginalName();
                $video = $request->video->getClientOriginalName();

                $request->image->storeAs('images',$image,'public');
                $request->video->storeAs('video',$video,'public');
                $request->video->storeAs('watermark',$watermark,'public');
            
                $vidName= rand().".mp4";
                $videoLocation = $this->processVideo($request, $vidName );           
           
                Video::create([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'image'=> $image,
                    'watermark' => $watermark,
                    'video' => $vidName,
                ]);  
                
                $message = "Video uploaded successfully";
                $video = Video::all();
                return view('admin.videoList',compact('video',$video));
            }else{
                return redirect()->back()->with('error', 'Video not uploaded, please try again');
            }           
        }catch(Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage());
        }
      
    }

    public function deleteVideo(Request $request){
        $id = $request->id;
        try{
            Video::find($id)->delete();
            $video = Video::all();
            return view('admin.videoList',compact('video',$video));
        }catch(Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage());
        }
       
    }

    public function processVideo($request, $vidName){
        
        $this->cropImage($request); 
        $inputVideo = public_path('storage/video/'.$request->video->getClientOriginalName());
        $outputVideo = public_path("storage/".$vidName);
        $watermark = public_path('storage/watermark/'.$request->watermark->getClientOriginalName());

        $ffmpath = public_path()."\plugins\\ffmpeg";
        $wmarkvideo = $ffmpath." -y -i ".$inputVideo." -i ".$watermark." -filter_complex ".
         '"overlay=x=(main_w-overlay_w):y=(main_h-overlay_h)/(main_h-overlay_h)"'." ".$outputVideo." &" ;

        shell_exec($wmarkvideo);
        
    }
    public function cropImage($request){
            $image       = $request->file('watermark');
            $filename    = $image->getClientOriginalName();        
            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(100, 100);
            $image_resize->save(public_path('storage/watermark/' .$filename));  
    }

}




