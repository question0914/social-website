<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Project;
use App\Review;
use MongoDB\Client as Mongo;
use MongoDB\BSON\ObjectID;

/**
* 	temporary depreacted
*/
class ReviewController extends Controller
{
	

	public function showAllReviews(Request $request){
		$user_id = $request->input('user_id');
		$reviews = Review::where('user_id', $user_id)->get();
		if($reviews)
			return $reviews->toJson();
		else
			return null;
	}

	public function createReview(Request $request){
		$reviewer_id = $request->input('reviewer_id');
		$project_id = $request->input('project_id');
		$user_id = $request->input('user_id');
		$title = $request->input('title');
		$content = $request->input('content');
		$time = $request->input('time');
		Review::create([
				'title' => 'John Project',
				'designer_id' => $designer_id,
				'content' => 'write something related to your project',
			]);
		return 'success';
	}

	public function deleteReview(Request $request){
		$review_id = $request->input('review_id');
		$review = Review::find($review_id);
		if($review){
			$review->delete();
			return 'success';
		}
		else
			return 'failed';
	}

	public function updateReview(Request $request){
		$project_id = $request->input('project_id');
		$collection = (new Mongo)->velozdesign->projects;
		$title = $request->input('title');
		$time = $request->input('time');
		$collection->updateOne(['_id' => new ObjectId($project_id)], ['$set' => ['title' => $title, 'content' => $time, 'test' => 'for fun']]);
		return $collection->findOne(['_id' => new ObjectId($project_id)]);
	}

	public function addProjectImage(Request $request){
		$project_id = $request->input('project_id');
		// $image = Image::create([
		// 		'title' => 'John Project Image',
		// 		'user_id' => '59669c469a89200664536448',
		// 		'content' => 'write something related to your project',
		// 		'link' => 'abc.com',
		// 	]);
		// Project::find($project_id)->push('image',['image_id'=>'123dcccds']);
		Project::find($project_id)->push('images',[
				'image_id' => uniqid(),
				'title' => 'John Project Image',
				'user_id' => '59669c469a89200664536448',
				'content' => 'write something related to your project',
				'link' => 'abc.com'
				]);

		return $this->showSpecificProject($project_id);

	}

	public function deleteProjectImage(Request $request){
		$project_id = $request->input('project_id');
		$image_id = $request->input('image_id');
		Project::find($project_id)->pull('images',['image_id' => $image_id]);

		return $this->showSpecificProject($project_id);
	}

	//
	public function updateProjectImage(Request $request){
		$project_id = $request->input('project_id');
		$image_id = $request->input('image_id');
		$title = $request->input('title');
		$link = $request->input('link');
		$collection = (new Mongo)->velozdesign->projects;
		$collection->updateOne(['_id' => new ObjectId($project_id), 'images.image_id' => $image_id], ['$set' => ['images.$.title' => $title, 'images.$.link' => $link]]);

		return $this->showSpecificProject($project_id);
	}

	public function showSpecificProject($id){
		$project = Project::find($id);

		return $project;
	}

}

