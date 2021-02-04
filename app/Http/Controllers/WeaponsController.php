<?php

namespace App\Http\Controllers;

use App\Weapon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class WeaponsController extends Controller
{
    public function create(Request $request)
    {
        try {
            $data = $request->all();

            $data['profile_id'] = Auth::user()->profile->id;

            $valid = Validator::make($data, [
                'name' => 'required|string|min:3',
                'type' => ['required', Rule::in(['Pistola', 'Assault', 'DMR', 'Sniper', 'Suporte'])]
            ]);

            $valid->validate();

            Weapon::create($data);

            toastr()->success('Arma adicionada!');
            return redirect()->route('membro-me');
        } catch (\Throwable $th) {
            toastr()->error('Ops.. ago de errado aconteceu');
            return redirect()->back();
        }
    }
}
