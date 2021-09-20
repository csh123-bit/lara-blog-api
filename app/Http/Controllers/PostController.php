<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\PostRequests;
use App\Models\Post;


class PostController extends Controller
{
    public function index(){
        logger('comment.user');
        $posts = Post::orderBy('id','desc')
        ->with(['categories','comments','user'])
        ->paginate(10);

        return response()->json($posts);
    }

    public function create(Request $request){
        $params = $request->only(['subject','content']);
        $params['user_id']=$request->user()->id;
        $post = Post::create($params);
        $ids = $request->input('category_ids');
        $post->categories()->sync($ids);
        $result = Post::where('id',$post->id)
        ->with(['user','categories'])->first();
        return response()->json($result);
    }

    public function read($id){
        $post = Post::where('id',$id)
        ->with(['comments','user'])->first();
        $post = Post::find($id);

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

        $user = $request->user();
        if($user->id!==$post->user_id){
            return response()->json(['message'=>'권한이 없습니다.'],403);
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

    public function delete(Request $request, $id){
        $post = Post::find($id);
        if(!$post){
            return response()->json(['message'=>'조회한 데이터가 없습니다.'],404);
        }

        $user = $request->user();
        if($user->id!==$post->user_id){
            return response()->json(['message'=>'권한이 없습니다.'],403);
        }


        $post->delete();

        return response()->json(["message"=>'delete one']);
    }
}
