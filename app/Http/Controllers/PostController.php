<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;


class PostController extends Controller implements HasMiddleware
{

  

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

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
    public function index(Request $request)
    {
        $perPage = $request->query('perPage' , 10);
        $page = $request->query('page' , 1);
        
        $posts =  Post::where('published',true)->paginate( $perPage , $columns = ['title','content'], $pageName="page");
        
        return [
            'status'=>true,
            'data' =>[
                'posts' => $posts->items(),
                'total' =>$posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                ]
            ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $fields = $request->validated();
        $post = $request->user()->posts()->create($fields);

        return ['status'=>true,'data' => ['post' => $post]];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = $this->findOrFail($id);
        return ['status'=>true,'data' => ['post' => $post]];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = $this->findOrFail($id);
        Gate::authorize('isAutherized', $post);

        $fields = $request->validated();

        $post->update($fields);
        return [
            'status'=>true,
            'data' => ['post' => $post]]; 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = $this->findOrFail($id);

        Gate::authorize('isAutherized', $post);
        $post->delete();

        return [
            'status'=>true,
            'data'=>['message' => 'Post Deleted Successfully']];
    }
}
