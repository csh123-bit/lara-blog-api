<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        $posts = Post::orderBy('id','desc')->get();
        return response()->json($posts);
    }

    public function create(Request $request){
        $subject = $request->input('subject');
        $content = $request->input('content');

        $post = new Post();
        $post->subject = $subject;
        $post->content = $content;
        $post->save();

        return response()->json($post);
    }

    public function read($id){
        //$post = Post::where('id',$id)->first();
        $post = Post::find($id);
        return response()->json($post);
    }
}
