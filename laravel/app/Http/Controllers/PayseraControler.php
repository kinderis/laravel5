<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PayseraControler extends Controller
{
    //
    public function index()
    {
        return view('Paysera.index');
    }
}
