<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptController extends Controller
{
    public function index(Request $request)
    {
        $decryptedValue = $request->query('encrypted_value');
        return view('index', compact('decryptedValue'));
    }
}
