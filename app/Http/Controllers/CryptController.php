<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $decryptedValue = DecryptValue($request);
        // dd($decryptedValue);
        return view("index");
    }

    public function greet(Request $request)
    {
        $decryptedValue = DecryptValue($request);
        $name = $decryptedValue->name;
        return view("greet", compact('name'));
    }
}
