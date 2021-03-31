<?php

namespace App\Http\Controllers;

use App\Event;
use App\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function home()
    {
        $user = Auth::user();

        return redirect($user->type === 'Membro' ? 'membro/dashboard' : 'liga/dashboard');
    }
}
