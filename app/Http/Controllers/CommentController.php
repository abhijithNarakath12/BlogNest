<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;





class CommentController extends Controller
{

    public function findOrFail($id): Post|JsonResponse
    {
        $post = Post::find($id);
        
        if (!$post) {
            throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Post Not Found',
            ], 404)
        );
        }
        
        return $post;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $post = $this->findOrFail($id);

        $comments = $post->comments()->with('replies')->cursorPaginate(10);
        return [ 
            'status'=>true,
            'data' => ['comments'=>$comments]
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, $id)
    {
        $post = $this->findOrFail($id);

        $comment = new Comment(['content' => $request->content, 'user_id'=>Auth::id()]);
        $data = $post->comments()->save($comment);
        return [
            'status'=> true,
            "data"=> ["comment"=>$data]
        ];
    }

    public function addReply(StoreCommentRequest $request, $id) {

        $comment = Comment::find($id);
        
        if (!$comment) {
            throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Comment Not Found',
            ], 404)
        );
        }

        $reply = new Comment(['content' => $request->content,'user_id'=>Auth::id()]);
        $data = $comment->replies()->save($reply);
        return [
            'status' => true,
            "data"=>["reply"=>$data]
        ];
    }
   
}
