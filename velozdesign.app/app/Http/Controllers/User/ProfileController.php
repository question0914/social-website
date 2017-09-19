<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use MongoDB\Client as Mongo;
use MongoDB\BSON\ObjectID;
use App\Service;
use App\User;

/*   Designer User Controller */
class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('designer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    /* ---- Update Name Profile :
        Post Request url:  '/api/profile/update_profile_name'
        object_data = {new_name : 'new name'}
     ----*/
    public function updateName(Request $request)
    {
        $currentUser = Auth::user();

        $currentUser->name = $request['new_name'];
        $currentUser->save();

        return $currentUser->name;
    }

    /* ---- Update Name Profile :
    Post request url:  '/api/profile/update_addition_info'
    object_data = {
        new_name : 'new name',
        new_location : 'new location',
        new_job_cost: 'job cost' }
    ----*/
    public function updateAdditionalInfo(Request $request)
    {
        $currentUser = Auth::user();
        $collection = (new Mongo)->velozdesign->users;
        $id = new ObjectID($currentUser->id);

        $contact_name = (isset($request['new_name']))? $request['new_name'] : $currentUser->additionInfo['contact_name'];
        $location = (isset($request['new_location']))? $request['new_location'] : $currentUser->additionInfo['location'];
        $job_cost = (isset($request['new_job_cost']))? $request['new_job_cost'] : $currentUser->additionInfo['job_cost'];

        $query = $collection->updateOne(
            ['_id' => $id],
            ['$set' => [
                'additionInfo.contact_name' => $contact_name,
                'additionInfo.location' => $location,
                'additionInfo.job_cost' => $job_cost
            ]]
        );
        $document = $collection->find(['_id' => $id])->toArray();
        return $document[0]['additionInfo'];
    }

    /* ---- Update Name Profile :
    Post request url:  '/api/feed/post'
    object_data = {
        content : 'content',
        sharing_visibility : 'public',
        link: {},
        image: {},
        video: {} }
    ---- */
    public function post(Request $request)
    {
        $currentUser = Auth::user();
        $collection = (new Mongo)->velozdesign->users;
        $id = new ObjectID($currentUser->id);

        // if(!isset($currentUser->Post)) {
        //     $query = $collection->updateOne(
        //         ['_id' => $id],
        //         ['$set' => ['Post' => []]]
        //     );
        // }

        $next_index = sizeof($currentUser->Post);

        $query = $collection->updateOne(
            ['_id' => $id],
            ['$set' => [
                'Post.'.$next_index.'.content' => $request['content'],
                'Post.'.$next_index.'.image' => [],
                'Post.'.$next_index.'.video' => [],
                'Post.'.$next_index.'.link' => [],
                'Post.'.$next_index.'.sharing_visibility' => 'public',
                'Post.'.$next_index.'.time' => date("Y-m-d h:i:sa")
            ]]
        );

        $document = $collection->find(['_id' => $id])->toArray();
        return $document[0]['Post'];

    }

    /* ---- Update Name Profile :
    Post request url:  '/api/feed/getuserdata'
    ----*/
    public function getUserData(Request $request)
    {
       return User::all();

    }

    /*  For User upload avatar image
    Method: Post,
    URL: /api/profile/update_avatar_image,
    Data:{
        'upload_url': url,
        'upload_file': image_file,
        'designer_id': 'designer_id'
    }
    */

    public function updateAvatar(Request $request){
        //There is sth wrong with isset, it returns 500 error even when I use GET method to request ajax --Bei

        $upload_url = $request->input('upload_url');
        $upload_file = $request->file('upload_file');
        $designer_id = $request->input('designer_id');
        if(!isset($upload_url) && !isset($upload_file))
             return null;
        if(!isset($designer_id))
            return null;
        if(isset($upload_url)){
            $upload_res = Service\AWS::uploadToS3FromUrl($request);
        }
        else
            $upload_res = Service\AWS::uploadToS3($request);

        if($upload_res){
            $user = User::find($designer_id);
            if (isset($user)) {
                User::find($designer_id)->unset('profile_img.avatar');
                User::find($designer_id)->push('profile_img.avatar',$upload_res);
                return $upload_res;
            }
            else
                return null;
        }
        else
            return null;
    }


    /*  For User upload cover image
    Method: Post,
    URL: /api/profile/update_cover_image,
    Data:{
        'upload_url': url,
        'upload_file': image_file,
        'designer_id': 'designer_id'
    }
    */
    public function updateCover(Request $request){

        $upload_url = $request->input('upload_url');

        $upload_file = $request->file('upload_file');
        $designer_id = $request->input('designer_id');

        if(!isset($upload_url) && !isset($upload_file))
             return null;
        if(!isset($designer_id))
            return null;
        if(isset($upload_url)){
            $upload_res = Service\AWS::uploadToS3FromUrl($request);
        }
        else
            $upload_res = Service\AWS::uploadToS3($request);

        if($upload_res){
            $user = User::find($designer_id);
            if (isset($user)) {
                $user->push('profile_img.cover',$upload_res);
                return $upload_res;
            }
            else
                return null;
        }
        else
            return null;
    }


}
