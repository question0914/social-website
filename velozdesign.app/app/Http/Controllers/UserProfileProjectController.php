<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Project;
use App\Image;
use MongoDB\Client as Mongo;
use MongoDB\BSON\ObjectID;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Service;

/**
*	In project part inside profile page, for both enduser and designer to get projects information or manage projects, like insert, search, update, delete basic information, images and videos.
*/
class UserProfileProjectController extends Controller
{

	private $database;

	public function __construct(){
		$this->database = env('MONGODB_DATABASE');
	}

	public function index(){

		// return $this->database;
		// return env('MONGODB_DATABASE');
		return (new Mongo)->selectDatabase($this->database)->projects->find()->toArray();
		// return $this->database;
		return view('Community.profileProject');
	}

	/* --- Show current visited user's all projects;
	Method: Post;
	Route: /project/show_user_project;
	object_data = { desiginer_id : 'id from current url'}
	return Project Json
	*/
	public function showUserProjects(Request $request){
		$designer_id = $request->input('designer_id');
		if (isset($designer_id)) {
			$projects = Project::where('designer_id',new ObjectId($designer_id))->get();

			if(isset($projects))
				return $projects;
			else
				return null;
		}
		else
			return null;
	}

	/* --- For designer create their own project;
	Method: Post;
	Route: /project/create_project;
	object_data = {
		desiginer_id : 'designer auth id',
		title: 'project name',
		content: 'content',
	}
	return: New Project;
	*/
	public function createProject(Request $request){
		$designer_id = $request->input('designer_id');
		$title = $request->input('title');
		$content = $request->input('content');
		if(!isset($designer_id) || !isset($title))
			return null;
		$user = User::find($designer_id);
		if(isset($user)){
			$new_project = Project::create([
					'title' => $title,
					'designer_id' => new ObjectId($designer_id),
					'content' => $content,
				]);
			$project_id = $new_project->_id;
			User::find($designer_id)->push('projects',[
						'project_id' => new ObjectId($project_id),
						]);
			return $this->showSpecificProject($project_id);
		}
		return null;
	}

	/* --- For designer delete their own project;
	Method: Post;
	Route: /project/delete_project;
	object_data = {
		desiginer_id : 'designer auth id',
		project_id: 'project name',
		content: '',
	}
	return All Projects
	*/
	public function deleteProject(Request $request){
		$project_id = $request->input('project_id');
		$designer_id = $request->input('designer_id');
		if(!isset($project_id) || !isset($designer_id))
			return null;
		$project = Project::find($project_id);
		if(isset($project)){
			if($project->designer_id == $designer_id){
				$project->delete();
				return Project::all();
			}
			else
				return null;
		}
		else
			return null;
	}

	/* --- For designer update their own project information;
	Method: Post;
	Route: /project/update_project_info;
	object_data = {
		desiginer_id : 'designer auth id',
		project_id: 'project id',
		title: 'title',
		content: 'content',
	}
	return updated project object;
	*/
	public function updateProjectInfo(Request $request){
		$project_id = $request->input('project_id');
		$designer_id = $request->input('designer_id');
		$collection = (new Mongo)->selectDatabase($this->database)->projects;
		$title = $request->input('title');
		$content = $request->input('content');
		if(!isset($project_id) || !isset($designer_id) || !isset($title) || !isset($content))
			return null;
		$project = Project::find($project_id);
		if(isset($project) && $project->designer_id == $designer_id){
			$collection->updateOne(['_id' => new ObjectId($project_id)], ['$set' => ['title' => $title, 'content' => $content, ]]);
			return $collection->findOne(['_id' => new ObjectId($project_id)]);
		}
		else
			return null;
	}


	/* --- For designer update their own project information;
	Method: Post;
	Route: /project/add_project_image;
	object_data = {
		user_id : 'designer auth id',
		project_id: 'project id',
		title: 'title',
		content: 'content',
		link: 'aws link'
	}
	return updated project object;
	*/
	public function addProjectImage(Request $request){

		// return 123;
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
			$project_id = $request->input('project_id');
			if (!isset($project_id))
				return null;
			Project::find($project_id)->push('images',[
					'image_id' => uniqid(),
					'title' => 'John Project Image',
					'user_id' => $designer_id,
					'content' => 'write something related to your project',
					'link' => $upload_res,
					]);

			return $this->showSpecificProject($project_id);
		}
		else
			return null;

	}

	public function addProjectImage2(Request $request){
		$upload_res = $this->uploadToS3FromUrl($request);

		// return "aaaa";

		if($upload_res){
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
					'link' => $upload_res,
					]);

			return $this->showSpecificProject($project_id);
		}
		else
			return null;

	}

	/* --- For designer delete image on specfic project;
	Method: Post;
	Route: /project/delete_project_image;
	object_data = {
		project_id: 'project id',
		image_id: 'image_id',
	}
	return updated project object;
	*/
	public function deleteProjectImage(Request $request){
		$project_id = $request->input('project_id');
		$image_id = $request->input('image_id');
		if(!isset($project_id) || !isset($image_id))
			return null;
		$collection = (new Mongo)->selectDatabase($this->database)->projects;
		$res = $collection->findOne(['_id' => new ObjectId($project_id), 'images.image_id' => $image_id],['projection' => ['images.$' => 1 ]]);
		// return $res->images[0]->link;
		if(isset($res) && isset($res->images) && isset($res->images[0]) && isset($res->images[0]->link)){
			$path = $res->images[0]->link;
		}
		else
			return null;

		if($this->deleteFromS3($path)){
			Project::find($project_id)->pull('images',['image_id' => $image_id]);
			return $this->showSpecificProject($project_id);
		}

		return null;
	}

	/* --- For designer update their own specfic project images;
	Method: Post;
	Route: /project/update_project_image;
	object_data = {
		project_id: 'project id',
		image_id: 'image_id',
		title: 'title',
		content: 'content',
		link: 'aws link'
	}
	return updated project object;
	*/
	public function updateProjectImage(Request $request){
		$project_id = $request->input('project_id');
		$image_id = $request->input('image_id');
		$title = $request->input('title');
		$link = $request->input('link');
		if (isset($project_id) && isset($image_id) && isset($title) && isset($link)) {
			$collection = (new Mongo)->selectDatabase($this->database)->projects;
			$collection->updateOne(['_id' => new ObjectId($project_id), 'images.image_id' => $image_id], ['$set' => ['images.$.title' => $title, 'images.$.link' => $link]]);

			return $this->showSpecificProject($project_id);
		}

		return null;

	}

	/* --- For designer update their own video project information;
	Method: Post;
	Route: /project/add_project_video;
	object_data = {
		user_id : 'designer auth id',
		project_id: 'project id',
		title: 'title',
		content: 'content',
		link: 'aws link'
	}
	return updated project object;
	*/
	public function addProjectVideo(Request $request){
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
			$project_id = $request->input('project_id');
			if (!isset($project_id))
				return null;
			Project::find($project_id)->push('videos',[
					'video_id' => uniqid(),
					'title' => 'John Project video',
					'user_id' => $designer_id,
					'content' => 'write something related to your project',
					'link' => $upload_res,
					]);

			return $this->showSpecificProject($project_id);
		}
		else
			return null;

	}

	/* --- For designer delete video on specfic project;
	Method: Post;
	Route: /project/delete_project_video;
	object_data = {
		project_id: 'project id',
		video_id: 'video_id',
	}
	return updated project object;
	*/
	public function deleteProjectVideo(Request $request){
		$project_id = $request->input('project_id');
		$image_id = $request->input('image_id');
		if(!isset($project_id) || !isset($image_id))
			return null;
		$collection = (new Mongo)->selectDatabase($this->database)->projects;
		$res = $collection->findOne(['_id' => new ObjectId($project_id), 'images.image_id' => $image_id],['projection' => ['images.$' => 1 ]]);
		// return $res->images[0]->link;
		if(isset($res) && isset($res->images) && isset($res->images[0]) && isset($res->images[0]->link)){
			$path = $res->images[0]->link;
		}
		else
			return null;

		if($this->deleteFromS3($path)){
			Project::find($project_id)->pull('images',['image_id' => $image_id]);
			return $this->showSpecificProject($project_id);
		}

		return null;
	}

	/* --- For designer update their own specfic project videos;
	Method: Post;
	Route: /project/update_project_video;
	object_data = {
		project_id: 'project id',
		video_id: 'video_id',
		title: 'title',
		content: 'content',
		link: 'aws link'
	}
	return updated project object;
	*/
	public function updateProjectVideo(Request $request){
		$project_id = $request->input('project_id');
		$video_id = $request->input('video_id');
		$title = $request->input('title');
		$link = $request->input('link');
		if (isset($project_id) && isset($image_id) && isset($title) && isset($link)) {
			$collection = (new Mongo)->selectDatabase($this->database)->projects;
			$collection->updateOne(['_id' => new ObjectId($project_id), 'videos.video_id' => $video_id], ['$set' => ['videos.$.title' => $title, 'videos.$.link' => $link]]);

			return $this->showSpecificProject($project_id);
		}

		return null;
	}

	public function showSpecificProject($id){
		$project = Project::find($id);
		if(isset($project))
			return $project;
		else
			return null;
	}

	public function uploadToS3(Request $request){
        $file = $request->file('upload_file');
//        $request->input('test');
        //return $request;

//        return $file->getClientOriginalExtension();

        $ext = $file->getClientOriginalExtension();
        if($file->isValid()){
             $s3 = \Storage::disk('s3');
//             return '123';
             $filePath = '/support-tickets/'.'imageUpload'.'.'.$ext;
             if($s3->put($filePath, file_get_contents($file), 'public')){
                $realPath = "https://s3.amazonaws.com/uploads.customtobacco.com".$filePath;
                return $realPath;
            }
            else
                return false;
        }
        return false;
    }

    public function uploadToS3FromUrl(Request $request){
        $url = $request->input('upload_url');
        $file=file_get_contents($url);
        $s3 = \Storage::disk('s3');
        $filePath = '/support-tickets/'.'imageUpload'.'.'.'jpg';
        if($s3->put($filePath, $file, 'public')){
            $realPath = "https://s3.amazonaws.com/uploads.customtobacco.com".$filePath;
            return $realPath;   //Path from AWS s3
        }
        return false;
    }

    public function deleteFromS3($path){
    	$s3 = \Storage::disk('s3');
    	$filePath = str_replace('https://s3.amazonaws.com/uploads.customtobacco.com', '', $path);
    	if($s3->delete($filePath))
    		return true;
    	else
    		return false;
    }

}
