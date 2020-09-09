<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){      
        return view('admin.index');
    }

    public function getUserForm(){
        return view('admin.addUser');
    }

    public function store(Request $request){
         $data = $request->validate([
            'first_name' => ['required', 'string','regex:/^[a-zA-Z]+$/u', 'max:255'],
            'last_name' => ['required', 'string', 'regex:/^[a-zA-Z]+$/u', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
         ]); 
    
        try{
            User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'role'=> 2,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);    
            $users = User::where('role', 2)->orderBy('id','DESC')->get();
            return view('admin.users',compact('users',$users));
        }catch(Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage());
        }
        }


    public function deleteUser(Request $request){
        $id = $request->id;
        try{
            User::find($id)->delete();
            $users = User::where('role', 2)->orderBy('id','DESC')->get();
            return view('admin.users',compact('users',$users));
        }catch(Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }


}
