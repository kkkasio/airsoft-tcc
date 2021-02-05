<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventSquad;
use App\ProfileEvent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class SquadsController extends Controller
{

    public function create(Request $request)
    {
        try {
            $data = $request->all();

            $valid = Validator::make($data, [
                'name' => 'string|required|min:3'
            ]);

            $valid->validate();

            $event = Event::find($data['event_id']);



            if (isNull($event->team)) {
                $squad = EventSquad::create($data);

                toastr()->success('Squad Criado!');
                return redirect()->back();
            }
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            dd($e);
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->all();

            $data['squad_id']   = $data['squad'];
            $data['profile_id'] = $data['profile'];
            $data['event_id']   = $data['event'];

            $valid = Validator::make($data, [
                'squad_id' => 'required|integer|not_in:0',
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
