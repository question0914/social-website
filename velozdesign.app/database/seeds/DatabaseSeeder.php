<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use MongoDB\BSON\ObjectID;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // $this->call(UsersDataSeedUpdate2::class);
        $this->call(UserTestDataSeed::class);
        $this->call(ProjectsDataSeed::class);
    }

}

/**
*
*/
class ProjectsDataSeed extends Seeder
{

    public function run()
    {
        DB::collection('projects')->delete();
        // $designer = DB::collection('users')->where('email','test@designer.com')->first();
        // $designer_id = (string)$designer['_id'];
        DB::collection('projects')->insert([
                '_id' => new ObjectId('59729c019a892015c635d100'),
                'title' => 'Seed Project',
                'designer_id' => new ObjectID('59729c019a892015c635d002'),
                'content' => 'write something related to your project',
                'images' => [(object)[
                        'image_id' => '123456789',
                        'title' => 'John Project Image',
                        'user_id' => new ObjectID('59729c019a892015c635d002'),
                        'content' => 'write something related to your image project',
                        'link' => 'https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/imageTest1.png',
                        ],
                        (object)[
                        'image_id' => '1234567891',
                        'title' => 'John Project Image 2',
                        'user_id' => new ObjectID('59729c019a892015c635d002'),
                        'content' => 'write something related to your image project',
                        'link' => 'https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/imageTest2.jpg',
                        ],
                        (object)[
                        'image_id' => '1234567892',
                        'title' => 'John Project Image 3',
                        'user_id' => new ObjectID('59729c019a892015c635d002'),
                        'content' => 'write something related to your image project',
                        'link' => 'https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/imageTest3.jpg',
                        ],
                        (object)[
                        'image_id' => '1234567893',
                        'title' => 'John Project Image 4',
                        'user_id' => new ObjectID('59729c019a892015c635d002'),
                        'content' => 'write something related to your image project',
                        'link' => 'https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/imageTest4.jpg',
                        ],
                    ],
                'video' =>[
                    (object)[
                        'video_id' => '98765432101',
                        'title' => 'John Project Video',
                        'user_id' => new ObjectID('59729c019a892015c635d002'),
                        'content' => 'write something related to your video project',
                        'link' => 'https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/testvideo2.mov',
                        ],
                ],
            ]);
        DB::collection('projects')->insert([
                '_id' => new ObjectId('59729c019a892015c635d101'),
                'title' => 'Seed Project 2',
                'designer_id' => new ObjectID('59729c019a892015c635d002'),
                'content' => 'write something related to your project 2',
                'images' => [(object)[
                        'image_id' => '12345678921',
                        'title' => '2nd Project Image',
                        'user_id' => new ObjectID('59729c019a892015c635d002'),
                        'content' => 'write something related to your image project',
                        'link' => 'https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/imageTest5.png',
                    ]],
            ]);
        DB::collection('projects')->insert([
                '_id' => new ObjectId('59729c019a892015c635d102'),
                'title' => 'Seed Project 3',
                'designer_id' => new ObjectID('59729c019a892015c635d002'),
                'content' => 'write something related to your project 3',
                'images' => [(object)[
                        'image_id' => '12345678931',
                        'title' => '3rd Project Image',
                        'user_id' => new ObjectID('59729c019a892015c635d002'),
                        'content' => 'write something related to your image project',
                        'link' => 'https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/imageTest6.jpg',
                    ]]
            ]);
        DB::collection('projects')->insert([
                '_id' => new ObjectId('59729c019a892015c635d103'),
                'title' => 'Seed Project 4',
                'designer_id' => new ObjectID('59729c019a892015c635d002'),
                'content' => 'write something related to your project 4',
                'images' => [(object)[
                        'image_id' => '12345678941',
                        'title' => '4th Project Image',
                        'user_id' => new ObjectID('59729c019a892015c635d002'),
                        'content' => 'write something related to your image project',
                        'link' => 'https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/imageTest7.jpeg',
                    ]]
            ]);
    }
}

class UserTestDataSeed extends Seeder{
    public function run(){
        DB::collection('users')->delete();
        DB::collection('users')->insert([
                '_id' => new ObjectId('59729c019a892015c635d002'),
                'name' => 'testDesigner',
                'email' => 'test@designer.com',
                'password' => bcrypt(123456),
                'role' => ['designer'],
                'gender' => 'male',
                'profile_img' => [
                    'avatar' => ['https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/imageTest10.jpg'],
                    'cover' => ['https://st.hzcdn.com/simgs/bd91d4b002fbf2b0_14-3483/contemporary-living-room.jpg','https://st.hzcdn.com/simgs/f1422b7d0806af97_17-3221/home-design.jpg',
                        'https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/imageTest8.jpeg',
                        ],
                    ],
                'url' => 'testDesigner-59729c019a892015c635d002',
                ]);
        DB::collection('users')->insert([
                '_id' => new ObjectId('59729c019a892015c635d001'),
                'name' => 'testEnduser',
                'email' => 'test@enduser.com',
                'password' => bcrypt(123456),
                'role' => ['enduser'],
                'gender' => 'male',
                'profile_img' => [
                    'avatar' => ['https://s3.amazonaws.com/uploads.customtobacco.com/support-tickets/imageTest9.jpg'],
                    ],
                'url' => 'testEnduser-59729c019a892015c635d001',
                ]);
        // $user = User::where('email','test@designer.com')->first();
        // $url = $user->name.'-'.$user->id;
        // $user->url = $url;
        // $user->save();
    }
}

class UsersDataSeedUpdate extends Seeder
{
    public function run()
    {
        App\User::updateOrCreate(
        	[
            'email'    => 'khanh@gmail.com',
        	],
        	[
        	'SocialMedia' => [

        					'Google' => ['link' => 'urllink','provideId' => 'id32432'],
        					'Facebook' => ['link' => 'fblink','provideId' => 'id32432']

        	]
        ]);
    }
}

class UsersDataSeedUpdate2 extends Seeder
{
    public function run()
    {
        App\User::updateOrCreate(
        	[
            'email'    => 'khanh@gmail.com',
        	],
        	[
        	'role' => [

        			'designer'
        	]
        ]);
    }
}

class UsersDataSeedNew extends Seeder
{
    public function run()
    {
        App\User::updateOrCreate([
            'name'     => 'EndUser',
            'email'    => 'enduser@gmail.com',
            'password' => bcrypt(123456),
        ],[
        	'role' => [
        		'enduser'
        	]
        ]);
    }
}

class AdminsDataSeed extends Seeder
{
    public function run()
    {
        App\Admin::updateOrCreate([
            'name'     => 'admin1',
            'email'    => 'admin1@gmail.com',
            'password' => bcrypt(123456),
            'role' => ['admin','enduser']
        ],[]);
    }
}


class UsersDataSeedDelete extends Seeder
{
    public function run()
    {
        App\User::where('email','enduser2@gmail.com')->delete();
    }
}
