<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Auth;
use App\Model;
use App\Service;
use MongoDB\BSON\ObjectID;
use MongoDB\Client as Mongo;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'name', 'email', 'password', 'role', 'gender', 'socialite', 'profile_img', 'review', 'follow'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'password', 'remember_token',
    ];

    public function getUrlId()
    {
        $user = Auth::user();
        return $user->url;
    }
    public function getAvatar() 
    {
        $user = Auth::user();
        return $user->profile_img['avatar'][0];
    }
    
    /*---- Checking current user has review with target user or project*/
    public function checkExistReview($target_id) 
    {
        $reviewing_id = new ObjectID(Auth::user()->id);
        $reviewer_id =  Service\Util::getObjectId($target_id);
        $exist_reviews = Model\Review::check_exist_review($reviewing_id, $reviewer_id);
        return $exist_reviews;
    }

    /*----- Check the follow between 2 user   ---*/   // NOT finish
    protected function check_exist_follow($follow_id) {
        $following_id = new ObjectID(Auth::user()->id);
        $follower_id =  Service\Util::getObjectId($follow_id);
        $user_collection = (new Mongo)->velozdesign->users;
        if ($follower_id == $following_id)
            return true;
        $exist_follows = $user_collection->find(['_id' => $following_id, 'follow.following_id.follower_id' => $follower_id])->toArray();

        print_r($exist_follows);
        if(empty($exist_reviews))
            return false; 
        else 
            return true;
    }
}
