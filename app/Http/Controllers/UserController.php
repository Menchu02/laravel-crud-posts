<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        // $user= new User();
        // $user->name="Pedro";
        // $user->email="pedro@gmail.com";
        // $user->password=Hash::make("12345");
        // $user->save();
        // return $user;
        $users=User::all();
        return $users;

        // $users= User::orderBy("id","desc")
        // ->get()
        // ;
        // return $users;
    }
}
