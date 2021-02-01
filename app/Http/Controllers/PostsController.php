<?php

namespace App\Http\Controllers;

use App\Post;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

        toastr()->success('O comunicado foi criado');

        return redirect()->route('liga-me');
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

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try {
            if ($data['id'] === $id) {

                $valid = Validator::make($data, [
                    'title' => 'required|string|max:255',
                    'content' => 'required|string',
                    'id' => 'required'
                ]);

                $valid->validate();

                $post = Post::find($id);

                $post->update($data);
                $post->save();

                toastr()->success('O comunicado foi atualizado');

                return redirect()->route('liga-me');
            }
            throw new Exception('Ops.. algo de errado aconteceu...');
        } catch (ValidationException $exception) {

            return redirect()->back()->withErrors($exception->validator)->withInput();
        } catch (Exception $e) {
            toastr()->error('Ops.. algo de errado aconteceu...');
            return redirect()->back();
        }
    }

    public function all()
    {
        $league = Auth::user()->league;

        $posts = Post::where('league_id', $league->id)->orderBy('created_at', 'desc')->get();

        return view('league.posts.all', compact('posts', $posts));
    }

    public function delete(Request $request)
    {
        try {
            $data = $request->all();
            $post = Post::find($data['post']);


            if (Auth::user()->league->id === $post->league_id) {
                $post->delete();

                toastr()->success('O comunicado foi deletado');
                return redirect()->back();
            }
        } catch (Exception $e) {
            toastr()->error('Ops.. algo de errado aconteceu...');
            return redirect()->back();
        }
    }
}
