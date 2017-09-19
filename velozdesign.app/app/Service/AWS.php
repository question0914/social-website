<?php

namespace App\Service;

use MongoDB\BSON\ObjectID;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;

/*
AWS management service, Using Laravel Filesystem
*/
class AWS
{
    // const DEFAULT_AWS_HOST = "https://s3-us-west-2.amazonaws.com/yiyuan";
    // set the default aws path by combine aws_region and aws_bucket
    const DEFAULT_AWS_HOST = "https://s3.amazonaws.com/uploads.customtobacco.com";
    const AWS_RELATIVE_PATH = "support-tickets";


    //Upload a http request which contains a file needed to upload to s3
    public static function uploadToS3(Request $request){
        $file = $request->file('upload_file');
//        $request->input('test');
        //return $request;

//        return $file->getClientOriginalExtension();

        $ext = $file->getClientOriginalExtension();
        if($file->isValid()){
             $s3 = \Storage::disk('s3');
//             return '123';
             $filePath = '/support-tickets/'.uniqid().'.'.$ext;
             if($s3->put($filePath, file_get_contents($file), 'public')){
                $realPath = (self::DEFAULT_AWS_HOST).$filePath;
                return $realPath;
            }
            else
                return false;
        }
        return false;
    }

    //Upload a http request with file url needed to upload to s3
    public static function uploadToS3FromUrl(Request $request){
        $url = $request->input('upload_url');
        $file=file_get_contents($url);
        $s3 = \Storage::disk('s3');
        $filePath = '/support-tickets/'.uniqid().'.'.'jpg';
        if($s3->put($filePath, $file, 'public')){
            $realPath = (self::DEFAULT_AWS_HOST).$filePath;
            return $realPath;   //Path from AWS s3
        }
        return false;
    }

    //delete a file on S3, according to relative path on s3
    public static function deleteFromS3($path){
    	$s3 = \Storage::disk('s3');
    	$filePath = str_replace(self::DEFAULT_AWS_HOST, '', $path);
    	if($s3->delete($filePath))
    		return true;
    	else
    		return false;
    }

    //returns an array of all of the files in a given direct directory
    public static function showFiles($directory){
        $s3 = \Storage::disk('s3');
        return $s3->files($directory);
    }

    //return a list of all files within a given directory including all sub-directories
    public static function showAllFiles($directory){
        $s3 = \Storage::disk('s3');
        return $s3->allFiles($directory);
    }

    // returns an array of all the directories within a given directory
    public static function directories($directory){
        $s3 = \Storage::disk('s3');
        return $s3->directories($directory);
    }

    //return a list of all directories within a given directory and all of its sub-directories
    public static function allDirectories($directory){
        $s3 = \Storage::disk('s3');
        return $s3->allDirectories($directory);
    }

    //create the given directory, including any needed sub-directories
    public static function makeDirectory($directory){
        $s3 = \Storage::disk('s3');
        if ($s3->makeDirectory($directory)) {
            return true;
        }
        return false;

    }

    //remove a directory and all of its files
    public static function deleteDirectory($directory){
        $s3 = \Storage::disk('s3');
        if ($s3->deleteDirectory($directory)) {
            return true;
        }
        return false;
    }


}
