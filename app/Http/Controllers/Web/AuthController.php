<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getLogin() {
        $authTocken = session('accessTocken');

        if(!!$authTocken){
            // return redirect()->route("dashboard");
            return redirect("http://127.0.0.1:8000/posts");

        }
        return view('login');
    }

    public function submitLogin(Request $request) {
        $request->validate([
            'email' => 'required|max:255',
            'password' => 'required'
        ]);
        $api = Request::create("/api/login","POST", ['email'=>$request->email, 'password'=>$request->password]);
        $response = app()->handle($api);
        $statusCode = $response->getStatusCode();
        if($statusCode ===200){
            $data = json_decode($response->getContent(), true);
            if($data["status"]){
                session(['accessTocken' => $data["data"]['token']]);
                return redirect("http://127.0.0.1:8000/posts");
                // return redirect()->route("dashboard");
    
            }
            // return redirect()->route("login");
            return redirect("http://127.0.0.1:8000/login");

        }else{
            $data = json_decode($response->getContent(), true);
            
        }
        // dd($data["data"]["token"]);

        
    }

    public function getSignUp() {
        return view('signup');
        
    }

    public function submitSignUp(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|max:255',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);
        $api = Request::create("/api/register","POST", [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'password_confirmation'=>$request->password_confirmation
        ]);


        $response = app()->handle($api);
        $data = json_decode($response->getContent(), true);

        if($data["status"]){
            // session(['accessTocken' => $data["data"]['token']]);
            // return redirect("http://127.0.0.1:8000/posts");
            // return redirect()->route("dashboard");

        }
        // return redirect()->route("login");
        // return redirect("http://127.0.0.1:8000/login");
    }
}
