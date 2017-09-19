<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Auth;
use MongoDB\Client as Mongo;
use App\Service;
use App\User;

class Review extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *    Note: reviewing:      I'm reviewing other person (reviewer).
     *          reviewer:       I got review from other person (reviewing).
     */
    protected $collection = 'reviews';
    protected $fillable = [
    'type', 'reviewer_id', 'reviewing_id', 'rate', 'title', 'content', 'create_time', 'update_time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    /*----- Get Brief total review and average rate of a user or project ---*/
    protected function get_review_rate_bref($re_id) {
        $review_collection = (new Mongo)->velozdesign->reviews;
        $reviewer_id =  Service\Util::getObjectId($re_id);
        $reviews = $review_collection->find(['reviewer_id' => $reviewer_id])->toArray();

        if(empty($reviews))
            return [ 'num_rate' => 0, 'average_rate' => 0 ];          
        else {
            $sum = 0;
            $i = 0;
            foreach ($reviews as $review) {
                if(isset($review->rate)){
                    $i++;
                    $sum += intval($review->rate);
                }
            }
        return [ 'num_rate' => $i, 'average_rate' => $sum/$i ];  
        }
    }
    /*----- Get all review of a user or project recieve ---*/
    protected function get_recieve_review($re_id) {
        $review_collection = (new Mongo)->velozdesign->reviews;
        $reviewer_id =  Service\Util::getObjectId($re_id);
        $reviews = $review_collection->find(['reviewer_id' => $reviewer_id],['sort' => ['update_time' => 1]])->toArray();

        if(empty($reviews))
            return [ 'num_rate' => 0, 'average_rate' => 0, 'reviews' => [] ]; 
        else {
            $sum = 0;
            $i = 0;
            foreach ($reviews as $review) {
                
                if(isset($review->rate)){
                    $i++;
                    $sum += intval($review->rate);   
                }
            }
        return [ 'num_rate' => $i, 'average_rate' => $sum/$i, 'reviews' => $reviews ];  
        }
    }
    /*----- Get all review of a you wrote ---*/
    protected function get_reviewing_review($user_id) {
        $review_collection = (new Mongo)->velozdesign->reviews;
        $reviewing_id =  Service\Util::getObjectId($user_id);
        $reviews = $review_collection->find(['reviewing_id' => $reviewing_id],['sort' => ['update_time' => 1]])->toArray();

        return [ 'num_review' => sizeof($reviews), 'reviews' => $reviews]; 
    }

    /*----- Check the exist review between 2 user or between a user and a project  ---*/
    protected function check_exist_review($reviewing_id, $reviewer_id) {
        $review_collection = (new Mongo)->velozdesign->reviews;
        if ($reviewer_id == $reviewing_id)
            return true;
        $exist_reviews = $review_collection->find(['reviewer_id' => $reviewer_id, 'reviewing_id' => $reviewing_id])->toArray();
        if(empty($exist_reviews))
            return false; 
        else 
            return true;
    }
}
