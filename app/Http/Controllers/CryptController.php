<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptController extends Controller
{
    use urlency;
    public function index(Request $request)
    {
        dd($request->name);
        // $decryptedValue = DecryptValue($request);
        // $decryptedData = $request->input('decrypted_data');
        // dd($decryptedValue);
        $ddd = surlency::ency ($request->get(""));
        return view("index");
    }

    public function greet(Request $request)
    {
        // $decryptedValue = DecryptValue($request);
        $name = $request->name;
        return view("greet", compact('name'));
    }
}
