<?php

namespace App\Http\Controllers;

use App\State;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    private $stateModel;


    public function __construct(State $state)
    {
        $this->stateModel = $state;
    }
    public function getCidades($estado_id){

        $state = $this->stateModel->find($estado_id);
        $cities = $state->cities()->getQuery()->get(['id', 'title']);

        return response()->json($cities);
    }
}
