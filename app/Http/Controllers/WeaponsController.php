<?php

namespace App\Http\Controllers;

use App\Weapon;
use Exception;
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
            return redirect()->route('membro-me-weapon-all');
        } catch (Exception $e) {
            dd($e->getMessage());
            toastr()->error('Ops.. ago de errado aconteceu');
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
    }

    public function allWeapons()
    {
        return view('member.weapons.index');
    }

    public function editForm($id)
    {
        $weapon = Weapon::find($id);
        $profile = Auth::user()->profile;

        if (!$weapon || !$weapon->profile_id === $profile->id) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }

        return view('member.weapons.edit', compact('weapon'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $profile = Auth::user()->profile;

            $valid = Validator::make($data, [
                'name' => 'required|string',
                'nickname' => 'required|string',
            ]);

            $valid->validate();

            $weapon = Weapon::find($id);

            if ($weapon->profile_id === $profile->id) {

                $weapon->update($data);
                $weapon->save();

                toastr()->success('Arma atualizada');
                return redirect()->route('membro-me-weapon-all');
            }
        } catch (Exception $e) {
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = $request->all();

            $weapon = Weapon::findOrFail($data['weapon']);
            $user = Auth::user()->profile;


            if ($user->id === $weapon->profile_id) {
                $weapon->delete();
                toastr()->success('A Arma foi removida');
                return redirect()->route('membro-me-weapon-all');
            }

            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        } catch (Exception $e) {
            dd($e);
            toastr()->error('Ops... algo de errado aconteceu');
            return redirect()->back();
        }
    }
}
