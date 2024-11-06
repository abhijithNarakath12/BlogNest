<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index() {

        $request = Request::create('/api/posts',"GET");
        $response = app()->handle($request);
        $data = json_decode($response->getContent(), true);

        $authTocken = session('accessTocken');
        // dd(!!$authTocken);
        $isAuthenticated = !!$authTocken; 
        // dd(auth()->check());


        if($data["status"]){
            return view('welcome',['posts'=> $data["data"]["posts"], 'isAuthenticated'=> $isAuthenticated]);
        }else{
            return view('welcome',['posts'=> [], 'isAuthenticated'=> false]);

        }
    }

    public function myPosts() {

        $authTocken = session('tocken');
        $request = Request::create('/api/posts',"GET");
        $response = app()->handle($request);
        $data = json_decode($response->getContent(), true);
    }
}
