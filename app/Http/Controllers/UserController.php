<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Video;
use App\User;

class UserController extends Controller
{
    
    public function index(){
        $video = Video::all();
        return view('users.index',compact('video',$video));
    }

    public function getAllUser(){
        $users = User::where('role', 2)->orderBy('id','DESC')->get();
        return view('admin.users',compact('users',$users));
    }
}
