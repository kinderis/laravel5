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
        $csvFile = public_path().'/csv/operation_x.csv';
        $data = $paysera->getResulData($csvFile);
        return view('Paysera.index',['data' => $data]);
    }
}
