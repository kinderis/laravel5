<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Paysera;

class PayseraControler extends Controller
{
    //
    public function index(Paysera $paysera)
    {
        $data = $paysera->getResulData();
        return view('Paysera.index',['data' => $data]);
    }
}
