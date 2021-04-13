<?php

namespace App\Http\Controllers;

use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $data = $request->all();

            if (!Hash::check($data['password'], $user->password)) {
                throw new Exception('Senha atual incorreta');
            }

            $valid = Validator::make($data, [
                'password' => ['required', 'string', 'min:6'],
                'new_password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $valid->validate();

            $update['password'] = Hash::make($data['new_password']);

            $user->update($update);
            toastr()->success('Senha atualizada com sucesso!');
            return redirect()->back();
        } catch (ValidationException $e) {
            toastr()->error('Ops... Dados incorretos verifique o formulário');
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }
}
