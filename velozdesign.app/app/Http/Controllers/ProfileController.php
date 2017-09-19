<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Model;
use App\Service;
use MongoDB\Client as Mongo;
use MongoDB\BSON\ObjectID;


class ProfileController extends Controller
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

        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $path = basename($actual_link);
        preg_match('/-([0-9a-z]*)\?*/', $path, $m );
        if (sizeof($m) < 1) {
            return view('welcome');
        }
        $profile_user_id = $m[1];
        if(Service\Util::checkProfileId($profile_user_id))  return view('welcome');


        $profile_data = User::find($profile_user_id);       // Get all profile user data

        if (Auth::guest()) {
            $show_review = false;
        } else {
            $show_review = !Auth::user()->checkExistReview($profile_user_id);
        }

        $response = [
            'user_profile_data' => $profile_data,
            'show_review_btn' => $show_review,
            'review_brief' => Model\Review::get_review_rate_bref($profile_user_id)
        ];

        if (isset($profile_data)) {
          $auth_user = Auth::user();
          if (isset($auth_user)) {
            return view('Community.profile',$response)->with('auth_id', $auth_user->_id)->with('auth_role', $auth_user->role[0]);
          }
          else
            return view('Community.profile',$response);
        } else {
            return view('welcome');
        }
    }

    /*  Get Public Profile of Designer:
    Get Request route:'profile/{token}'
    Token generate by name + id of user.   ----*/
    public function index2()
    {

        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $path = basename($actual_link);
        preg_match('/-([0-9a-z]*)\?*/', $path, $m );
        if (sizeof($m) < 1) {
            return view('welcome');
        }
        $profile_user_id = $m[1];
        if(Service\Util::checkProfileId($profile_user_id))  return view('welcome');

        
        $profile_data = User::find($profile_user_id);       // Get all profile user data

        if (Auth::guest()) {
            $show_review = false;
        } else {
            $show_review = !Auth::user()->checkExistReview($profile_user_id);
        }

        $response = [
            'user_profile_data' => $profile_data, 
            'show_review_btn' => $show_review,
            'review_brief' => Model\Review::get_review_rate_bref($profile_user_id)
        ];

        if (isset($profile_data)) {
            return view('Profile.profile',$response);
        } else {
            return view('welcome');
        }
    }

    /* ---- Add New Public Contact from guest :  
    Post Request url:  '/api/profile/add_contact_info'  
    object_data = { 
        profile_id = 'current profile id',
        guest_name : 'new name',
        guest_email : ' email' ,
        guest_phone : 'phone' ,
        guest_message : 'message' }   ----*/
    public function add_contactInfo(Request $request)
    {
        $profileId = $request['profile_id'];
        $currentUser = User::find($profileId);
        $collection = (new Mongo)->velozdesign->users;

        $id = Service\Util::getObjectId($profileId);

        if(!isset($currentUser->guest_contact)) {
            $query = $collection->updateOne(
                ['_id' => $id],
                ['$set' => ['guest_contact' => []]]
            );
        }
        $next_index = sizeof($currentUser->guest_contact);

        $updateQuery = [];
        if(isset($request['guest_name']))
            $updateQuery['guest_contact.'.$next_index.'.guest_name'] = $request['guest_name'];
        if(isset($request['guest_email']))
            $updateQuery['guest_contact.'.$next_index.'.guest_email'] = $request['guest_email'];
        if(isset($request['guest_phone']))
            $updateQuery['guest_contact.'.$next_index.'.guest_phone'] = $request['guest_phone'];
        if(isset($request['guest_message']))
            $updateQuery['guest_contact.'.$next_index.'.guest_message'] = $request['guest_message'];
        /* -- Insert into database -----*/
        $query = $collection->updateOne( ['_id' => $id], ['$set' => $updateQuery] );

        $document = $collection->find(['_id' => $id])->toArray();
        return $document[0]['guest_contact'][$next_index];
    }


    /* --- Get User Profile Data: Post route:'api/get_user_data'  object_data = {url_id : 'id from current url'}   ----*/
    public function get_user_profile(Request $request) {
        $id = $request['url_id'];
        // $id = "596400d99a89200652418912";
        return User::find($id);
    }

    public function get_projects(Request $request){
       $projects_data['id'] = $request['id'];
       $projects_data['email'] = $request['email'];
       $projects_data['gender'] = $request['gender'];
       $projects_data['name'] = $request['name'];
       $projects_data['tab'] = $request['tab'];
       return view('Community.projects',['projects_data'=>$projects_data]);
    }

    public function get_activity(Request $request){
       $projects_data['id'] = $request['id'];
       $projects_data['email'] = $request['email'];
       $projects_data['gender'] = $request['gender'];
       $projects_data['name'] = $request['name'];
       $projects_data['tab'] = $request['tab'];
       return view('Community.activity',['projects_data'=>$projects_data]);
    }

    /* --- Get Average Review Score:
    *   Post route:'api/review/get_review_rate_bref'
    *   object_data = {reciever_id : 'id from current profile'}   ----
    */
    public function get_review_rate_bref(Request $request) {
        $review_score = Model\Review::get_review_rate_bref($request['reciever_id']);
        return $review_score;
    }

    /* --- Get all review of a user or project
    *   Post route:'api/review/get_recieve_review'
    *   object_data = {reciever_id : 'id from current profile'}   ----
    */
    public function get_recieve_review(Request $request) {
        $reviews = Model\Review::get_recieve_review($request['reciever_id']);
        return $reviews;
    }
    /* Testing get DB ---*/
    public function test(){
        $name = env('MONGODB_DATABASE');
        $collection = (new Mongo)->selectDatabase($name)->users;

        return $collection->findOne(['name' => 'khanh']);

    }

}
