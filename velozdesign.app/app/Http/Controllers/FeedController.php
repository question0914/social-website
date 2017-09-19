<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use MongoDB\Client as Mongo;
use MongoDB\BSON\ObjectID;

class FeedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    /*  Get Public Profile of Designer: 
    Get Request route:'profile/{token}'    
    Token generate by name + id of user.   ----*/
    public function index()
    {   
        $all_user = User::all();

        return view('Community.feed',['user_data' => $all_user]);
    }


   
}
