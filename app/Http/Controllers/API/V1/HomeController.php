<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data["title"] = "Login";
        $data["page"] = "home";
        return view('login', $data);
    }
    public function register()
    {
        $data["title"] = "Register";
        $data["page"] = "register";
        return view('register', $data);
    }
    public function ProfileSetiing()
    {
       
        if (isset($_COOKIE["authToken"])) {
            $getUser = User::where("username", $_COOKIE["username"])->first();
            $data["title"] = "Profile Setiing";
            $data["page"] = "profile-setiing";
            $data["user"] = $getUser;
            return view('userprofile', $data);
        }else{
            return redirect("/");
        }
    }
}
