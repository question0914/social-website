<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use MongoDB\Client as Mongo;
use MongoDB\BSON\ObjectID;
use MongoDB\BSON\UTCDateTime;
use DateTime;
use App\User;
use App\Project;
use App\Service;
use App\Model;

class AllUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    /* ---- Post  Review  [ All User]:
     *    Post request url:  '/api/user/review/create_review_user'
     *    object_data = {
     *        reviewer_id: 'current profile Id',
     *        title: 'title of review',
     *        content : 'review content',
     *        rate : '',
     *    }
     *    Note: reviewing:   I'm reviewing other person (reviewer).
     *          reviewer:  I got review from other person (reviewing).
     *
     */
    public function create_review_user(Request $request)
    {
        $reviewingUser = Auth::user();
        $user_collection = (new Mongo)->velozdesign->users;
        $review_collection = (new Mongo)->velozdesign->reviews;

        $reviewing_id = new ObjectID($reviewingUser->id);
        $reviewer_id = Service\Util::getObjectId($request['reviewer_id']);
        $exist_reviews = Model\Review::check_exist_review($reviewing_id, $reviewer_id);
        if (!$exist_reviews) {

            $reviewerUser = User::find($request['reviewer_id']);
            $curr_user_index = sizeof($reviewingUser->review['reviewing']);
            $prof_user_index = sizeof($reviewerUser->review['reviewer']);

            $current_date = new UTCDateTime((new DateTime(date('Y-m-d\TH:i:s.uP')))->getTimestamp()*1000);


            /* ---- Make record to Review collection --- */
            $queryMakeReview = $review_collection->insertOne(
             [
             'type' => 'user',
             'reviewer_id' => $reviewer_id,
             'reviewing_id' => $reviewing_id,
             'rate' => $request['rate'],
             'title' => $request['title'],
             'content' => $request['content'],
             'create_time' => $current_date,
             'update_time' => $current_date
             ]
             );
            $review_id =  $queryMakeReview->getInsertedId();

            /* Update to Current/Rewiewing User and which profile they review*/
            $query = $user_collection->updateOne(
                ['_id' => $reviewing_id],
                ['$set' => [
                'review.reviewing.'.$curr_user_index.'.reviewer_id' => $reviewer_id,
                'review.reviewing.'.$curr_user_index.'.review_id' => $review_id
                ]]
                );
            /* Update to Current/Reviewer Profile User and who write a review*/
            $query = $user_collection->updateOne(
                ['_id' => $reviewer_id],
                ['$set' => [
                'review.reviewer.'.$prof_user_index.'.reviewing_id' => $reviewing_id,
                'review.reviewer.'.$prof_user_index.'.review_id' => $review_id
                ]]
                );

            $document = $review_collection->find()->toArray();
            return $document;
        }
        else {
            return "The same person review or exist review";
        }
    }

    /* ---- Post Review  [Project]:
     *    Post request url:  '/api/user/review/create_review_project'
     *    object_data = {
     *        reviewer_id: 'current project Id',
     *        title: 'title of review',
     *        content : 'review content',
     *        rate : '',
     *    }
     */  ///Not Finish
    public function create_review_project(Request $request)
    {
        $reviewingUser = Auth::user();
        $user_collection = (new Mongo)->velozdesign->users;
        $review_collection = (new Mongo)->velozdesign->reviews;
        $project_collection = (new Mongo)->velozdesign->projects;

        $reviewing_id = new ObjectID($reviewingUser->id);
        $reviewer_id = Service\Util::getObjectId($request['reviewer_id']);

        if ($this->checkOwnerProject($reviewingUser, $reviewer_id)) {

            $reviewer_model = Project::find($request['reviewer_id']);
            $curr_user_index = sizeof($reviewingUser->review['reviewing']);
            $project_index = sizeof($reviewer_model->review);

            $current_date = new UTCDateTime((new DateTime(date('Y-m-d\TH:i:s.uP')))->getTimestamp()*1000);


            /* ---- Make record to Review collection --- */
            $queryMakeReview = $review_collection->insertOne(
             [
             'type' => 'project',
             'reviewer_id' => $reviewer_id,
             'reviewing_id' => $reviewing_id,
             'rate' => $request['rate'],
             'title' => $request['title'],
             'content' => $request['content'],
             'create_time' => $current_date,
             'update_time' => $current_date
             ]
             );
            $review_id =  $queryMakeReview->getInsertedId();

            /* Update to Current/reviewing User and which profile they review*/
            $query = $user_collection->updateOne(
                ['_id' => $reviewing_id],
                ['$set' => [
                'review.reviewing.'.$curr_user_index.'.reviewer_id' => $reviewer_id,
                'review.reviewing.'.$curr_user_index.'.review_id' => $review_id
                ]]
                );
            /* Update to Current Profile User and who write a review*/
            $query = $project_collection->updateOne(
                ['_id' => $reviewer_id],
                ['$set' => [
                'review.'.$project_index.'.reviewing_id' => $reviewing_id,
                'review.'.$project_index.'.review_id' => $review_id
                ]]
                );


            $document = $review_collection->find()->toArray();
            return $document;
        }
        else {
            return "The same person review or exist reviews";
        }
    }

    /* ---- Update Review  [ User | Project ]:
     *    Post request url:  '/api/user/review/update_review'
     *    object_data = {
     *        review_id: 'target review id',
     *        title: 'title of review',
     *        content : 'review content',
     *        rate : '4',
     *    }
     */
    public function update_review(Request $request)
    {
        $reviewingUser = Auth::user();
        $review_collection = (new Mongo)->velozdesign->reviews;

        $reviewing_id = new ObjectID($reviewingUser->id);
        $review_id = Service\Util::getObjectId($request['review_id']);

        $update_date = new UTCDateTime((new DateTime(date('Y-m-d\TH:i:s.uP')))->getTimestamp()*1000);
        $updateQuery = [];
        if(isset($request['rate']))
            $updateQuery['rate'] = $request['rate'];
        if(isset($request['title']))
            $updateQuery['title'] = $request['title'];
        if(isset($request['content']))
            $updateQuery['content'] = $request['content'];
        $updateQuery['update_time'] = $update_date;

        $update_review = $review_collection->updateOne(
            [ '_id' => $review_id,  'reviewing_id' => $reviewing_id ],
            ['$set' =>  $updateQuery]
        );

        if( $update_review->getMatchedCount() >= 1 && $update_review->getModifiedCount() >= 1) {
            $document = $review_collection->find()->toArray();
            return $document;
        } else {
            return "Wrong";
        }
    }

    private function checkOwnerProject($reviewerUser, $project_id) {
        return true;
    }

    /*---- Checking current user has review with target user or project
     *   Post request url:  '/api/user/review/check_exist_review'
     *   object_data = {
     *       reviewer_id: 'target get review id'
     *       }
     */
    public function check_exist_review(Request $request)
    {

        $exist_reviews = Auth::user()->checkExistReview($request['reviewer_id']);
         $res['data']= $exist_reviews;
        return $res;
    }

    /* --- Get All review of you wrote
     *   Get url route:'api/user/review/get_reviewing_review'
     *
     */
    public function get_reviewing_review(Request $request) {
        $reviewing_id = Auth::user()->id;
        $reviews = Model\Review::get_reviewing_review($reviewing_id);
        return $reviews;
    }

    /**
     *   Follow a user profile  [All User]:
     *    Post request url:  '/api/user/follow/follow_user'
     *    object_data = {
     *        follower_id: 'target profile Id'
     *    }
     */
    public function follow_user(Request $request)
    {
        $following_User = Auth::user();
        $user_collection = (new Mongo)->velozdesign->users;

        $following_id = new ObjectID($following_User->id);
        $follower_id = Service\Util::getObjectId($request['follower_id']);
        $exist_follow = User::check_exist_follow($request['follower_id']);
        if (!$exist_follow) {

            $follower_User = User::find($request['follower_id']);
            $following_index = sizeof($following_User->follow['following']);
            $follower_index = sizeof($follower_User->follow['follower']);

            $current_date = new UTCDateTime((new DateTime(date('Y-m-d\TH:i:s.uP')))->getTimestamp()*1000);

            /* Update to Following User and which user they follow */
            $query = $user_collection->updateOne(
                ['_id' => $following_id],
                ['$set' => [
                'follow.following.'.$following_index.'.follower_id' => $follower_id,
                'follow.following.'.$following_index.'.follow_date' => $current_date
                ]]
                );
            /* Update to Current/Follower Profile User and who/following follow him*/
            $query = $user_collection->updateOne(
                ['_id' => $follower_id],
                ['$set' => [
                'follow.follower.'.$follower_index.'.following_id' => $following_id,
                'follow.follower.'.$follower_index.'.follow_date' => $current_date
                ]]
                );

            $document = $user_collection->findOne([ '_id' => $follower_id]);
            return $document;
        }
        else {
            return "The same person follow or exist follow";
        }
    }
}
