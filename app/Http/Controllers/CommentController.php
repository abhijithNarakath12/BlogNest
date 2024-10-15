<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        // $comments= Comment::where("post_id",$post->id)->whereNull('parent_comment_id')->with('replies')->cursorPaginate(10);
        $comments = $post->comments()->with('replies')->cursorPaginate(10);
        return ['comments'=>$comments];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        // $comment = $request->user()->comments()->create($request->validated());
        $comment = new Comment(['content' => $request->content,'user_id'=>Auth::id()]);
        $data = $post->comments()->save($comment);
        return ["data"=>["content"=>$data]];
    }

    public function addReply(StoreCommentRequest $request, Comment $comment) {

        $reply = new Comment(['content' => $request->content,'user_id'=>Auth::id()]);
        $data = $comment->replies()->save($reply);
        return ["data"=>["reply"=>$data]];
    }
   
}
