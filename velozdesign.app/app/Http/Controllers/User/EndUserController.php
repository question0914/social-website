<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use MongoDB\Client as Mongo;
use MongoDB\BSON\ObjectID;

class EndUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('enduser');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    /* ---- Update End User Name :  
        Post Request url:  '/api/user/change_name'  
        object_data = {new_name : 'new name'}  
     ----*/
    public function changeName(Request $request)
    {
        $currentUser = Auth::user();
        $currentUser->name = $request['new_name'];
        $currentUser->save();

        return $currentUser->name;
    }

    /* ---- Update User Personal Information :  
    Post request url:  '/api/user/update_personal_info'  
    object_data = {
        new_phone : 'new name', 
        new_location : 'new location',
        new_birthdate: 'birth date' }   
    ----*/
    public function updatePersonalInfo(Request $request)
    {
        $currentUser = Auth::user();
        $collection = (new Mongo)->velozdesign->users;
        $id = new ObjectID($currentUser->id);

        $phone = (isset($request['new_phone']))? $request['new_phone'] : $currentUser->personalInfo['phone'];
        $location = (isset($request['new_location']))? $request['new_location'] : $currentUser->personalInfo['location'];
        $birthdate = (isset($request['new_birthdate']))? $request['new_birthdate'] : $currentUser->personalInfo['birthdate'];
        
        $query = $collection->updateOne(
            ['_id' => $id],
            ['$set' => [
                'personalInfo.phone' => $phone,
                'personalInfo.location' => $location,
                'personalInfo.birthdate' => $birthdates
            ]]
        );
        $document = $collection->find(['_id' => $id])->toArray();
        return $document[0]['personalInfo'];
    }
}
