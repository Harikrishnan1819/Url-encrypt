<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptController extends Controller
{
    public function index(Request $request)
    {
        $encrypt= EncryptValue(url('greet'),['name'=>'arun']);
        return redirect($encrypt);
        // return view("index");
    }

    public function greet(Request $request)
    {
        $name = $request->name;
        return view("greet", compact('name'));
    }
}
