<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(url('/api/posts'));
    
        $data = $response->json();
        return view('welcome', ['posts' => $posts]);    
        
    }
}
