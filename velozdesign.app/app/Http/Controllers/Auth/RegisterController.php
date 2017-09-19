<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        switch ($data['gender']) {
            case 'male':
            $avatar_defaut = 'https://www.timeshighereducation.com/sites/default/files/byline_photos/default-avatar.png';
            break;
            case 'female':
            $avatar_defaut = 'http://pspmr.org/wp-content/uploads/2017/02/default-female-avatar.png';
            break;
            default:
            $avatar_defaut = 'https://www.ioa.uni-bonn.de/de/studiengangsmanagement/mentoren/avatar-1577909-960-720.png';
            break;
        }

        $review = new \stdClass;
        $review->reviewing = [];
        $review->reviewer = [];
        $follow = new \stdClass;
        $follow->following = [];
        $follow->follower = [];

        switch ($data['role']) {
            case 'designer':
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => [$data['role']],
                'gender' => $data['gender'],
                'profile_img' => (object) [
                    'avatar' => [$avatar_defaut],
                    'cover' => ['https://st.hzcdn.com/simgs/bd91d4b002fbf2b0_14-3483/contemporary-living-room.jpg','https://st.hzcdn.com/simgs/f1422b7d0806af97_17-3221/home-design.jpg'],
                    ],
                'review' => $review,
                'follow' => $follow,
                ]
                );
            break;
            default:
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => [$data['role']],
                'gender' => $data['gender'],
                'profile_img' => (object)[
                    'avatar' => [$avatar_defaut],
                ],
                'review' => $review,
                'follow' => $follow,
                ]);
            break;
        }
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        /* --- Add Url ---- */
        $this->generateURL($user);

        $this->guard()->login($user);

        foreach($this->guard()->user()->role as $role) 
        {
            if ($role == 'enduser')
            {
                return redirect('/home');
            } 
            elseif ($role == 'designer' /*|| $role->name == 'architecter'*/)
            {
                return redirect('/profile/'.Auth::user()->getUrlId());
            }
        }
    }

    private function generateURL($user)
    {
        foreach($user->role as $role) 
        {
            if ($role == 'designer')
            {
                $newname =  preg_replace('/\s+/', '', $user->name);
                $newname =  preg_replace('/\-+/', '', $newname);
                $url =  $newname.'-'.$user->id;
                $user->url = $url;
                $user->save();
                break;
            } 
        }
    }
}
