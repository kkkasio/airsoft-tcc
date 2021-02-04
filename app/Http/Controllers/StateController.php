<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function getEstados(){
        $estados = State::all('id','title');

        return response()->json($estados);
    }
}
