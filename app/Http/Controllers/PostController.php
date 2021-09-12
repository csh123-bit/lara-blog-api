<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\PostRequests;
use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        $posts = Post::orderBy('id','desc')
        ->with(['categories','comments'])
        ->paginate(10);

        return response()->json($posts);
    }

    public function create(Request $request){
        $params = $request->only(['subject','content']);
        $post = Post::create($params);
        $ids = $request->input('category_ids');
        $post->categories()->sync($ids);
        return response()->json($post);
    }

    public function read($id){
        $post = Post::where('id',$id)->with('comments')->first();
        //$post = Post::find($id);

        if(!$post){
            return response()->json(['message'=>'조회한 데이터가 없습니다.'],404);
        }
        return response()->json($post);
    }

    public function update(Request $request,$id){
        $post = Post::find($id);
        if(!$post){
            return response()->json(['message'=>'조회한 데이터가 없습니다.'],404);
        }
        $subject = $request->input('subject');
        $content = $request->input('content');
        $ids = $request->input('category_ids');

        if($subject) $post->subject = $subject;
        if($content) $post->content = $content;
        $post->save();
        $ids = $request->input('category_ids');

        return response()->json($post);
    }

    public function delete($id){
        $post = Post::find($id);
        if(!$post){
            return response()->json(['message'=>'조회한 데이터가 없습니다.'],404);
        }
        $post->delete();

        return response()->json(["message"=>'delete one']);
    }
}
