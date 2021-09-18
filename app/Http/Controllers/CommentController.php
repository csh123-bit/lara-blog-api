<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function create(Request $request, $postId){
        $post = Post::find($postId);

        if(!$post){
            return abort(404);
        }

        $content = $request->input('content');

        $user = $request->user();
        $comment = new Comment();

        $comment->user_id = $user->id;
        $comment->post_id = $post->id;
        $comment->content = $content;
        $comment->save();

        return response()->json($comment);
    }

    public function delete(Request $request,$postId, $id){
        $comment = Comment::where('post_id',$postId)
        ->where('id',$id)->first();

        if(!$comment){
            abort(404);
        }
        $user = $request->user();
        if($user->id!==$comment->user_id){
            return abort(403);
        }
        $comment->delete();
        return response()->json(['message'=>'삭제되었습니다']);
    }
}
