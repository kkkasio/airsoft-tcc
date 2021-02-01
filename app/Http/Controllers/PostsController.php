<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();

        $data['league_id'] = Auth::user()->id;

        $valid = Validator::make($data, [
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);


        $valid->validate();

        $post = Post::create($data);

        return redirect()->route('liga-me')->with(['message' => 'Comunicado criado com sucesso!', 'type' => 'success']);
    }

    public function form()
    {
        return view('league.posts.create');
    }

    public function editForm($id)
    {
        try {

            $league = Auth::user()->league;
            $post = Post::where('id', $id)->first();

            if ($post->league_id === $league->id) {
                return view('league.posts.edit', compact('post'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['message', 'Ops.. algo de errado aconteceu...', 'type' => 'error']);
        }
    }

    public function update(Request $request, $id){
        $data = $request->all();

        try {
            if($data['id'] === $id){

                $valid = Validator::make($data, [
                    'title' => 'required|string|max:255',
                    'content' => 'required|string',
                    'id' => 'required'
                ]);

                $valid->validate();

                $post = Post::find($id);

                $post->update($data);
                $post->save();

                return redirect()->back()->with(['message', 'O comunicado foi atualizado', 'type' => 'success']);


            }
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message', 'Ops.. algo de errado aconteceu...', 'type' => 'error']);

        }
    }
}
