<?php

namespace App\Http\Controllers;

use App\Event;
use App\ProfileEvent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SquadsController extends Controller
{
    public function update(Request $request)
    {
        try {
            $data = $request->all();

            $data['squad_id']   = $data['squad'];
            $data['profile_id'] = $data['profile'];
            $data['event_id']   = $data['event'];

            $valid = Validator::make($data, [
                'squad_id' => 'required|integer',
                'profile_id' => 'required|integer',
                'event_id' => 'required|integer',
            ]);

            $valid->validate();

            $subscribe = ProfileEvent::where('event_id', $data['event_id'])->where('profile_id', $data['profile_id'])->first();


            if ($subscribe) {
                $subscribe->update(['squad_id' => $data['squad_id']]);
                $subscribe->save();

                toastr()->success('Squad atualizado');
                return redirect()->back();
            }

            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }
}
