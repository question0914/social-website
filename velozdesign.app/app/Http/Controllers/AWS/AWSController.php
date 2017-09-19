<?php

namespace App\Http\Controllers\AWS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use AWS;

class AWSController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function upload(){
        $s3 = \Storage::disk('s3');
        $filePath = '/support-tickets/test1';
        $image = $image = public_path().'/download.jpeg';
        $url = "https://cdn.pixabay.com/photo/2016/02/19/15/46/dog-1210559_960_720.jpg";
        if($s3->put($filePath, file_get_contents($url), 'public'))
            return "success";
        else
            return "failed";
        // return $image;
    }

    /* not good way to upload to S3 */
    public function upload2(){
        // $image = asset('download.jpeg');
        $image = public_path().'/download.jpeg';
        // header("Content-type: image/jpg");
        // echo file_get_contents($image);
        // return public_path();
        $url = "https://cdn.pixabay.com/photo/2016/02/19/15/46/dog-1210559_960_720.jpg";
        $s3 = AWS::createClient('s3');
            $s3->putObject(array(
                'Bucket'     => env('AWS_BUCKET'),
                'Key'        => 'test2',
                'SourceFile' => $image,
            ));

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
                return "false";
        }
    }
    public function uploadToS3FromUrl(Request $request){
        $url = $request->input('upload_url');
        $file=file_get_contents($url);
        $s3 = \Storage::disk('s3');
        $filePath = '/support-tickets/'.'imageUpload1'.'.'.'jpg';
        if($s3->put($filePath, $file, 'public')){
            $realPath = "https://s3.amazonaws.com/uploads.customtobacco.com".$filePath;
            return $realPath;   //Path from AWS s3
        }
        return "Failed!";
    }
}
