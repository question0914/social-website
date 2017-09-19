<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Auth;
use Socialite;
use App\User;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    //Editing
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

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

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        // if($provider == 'google')
        //     return Socialite::driver('google')->scopes(['profile','email'])->redirect();
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->checkUserEmailExist($user, $provider);
        if ($authUser) {
            Auth::login($authUser, true);
            return redirect()->to('/home');
        }
        else{
            return view('select')->with('users',$user)->with('provider',$provider);
        }

        // $user->token;
        // return redirect()->to('/home');
    }

    public function checkUserEmailExist($user, $provider)
    {
        $authUser = User::where('email', $user->email);
        if ($authUser->first()) {
            // echo "111";
            // var_dump($authUser->first());
            if($authUser->where('socialite.provider',$provider)->first()){
                // echo "222";
                if($authUser->where('socialite.provider_id',$user->id)->first())
                    return $authUser->first();
            }
            else{
                $authUser = User::where('email', $user->email);
                // var_dump($authUser->first());
                $authUser->push('socialite',[
                        'provider' => $provider,
                        'provider_id' => $user->id,
                        'name' => $user->name,
                    ]);

                return $authUser->first();
            }
            // return redirect()->to('/home');
        }
        else
            return null;
    }

    public function selectRole(Request $request){
        // var_dump($request);
        $input = $request->all();
        // var_dump($request->input('_token'));

        // var_dump(User::where('email','ianchen227@gmail.com')->get()->toJson());
        // return;
        $provider = $input['provider'];
        $role = $input['role'];
        $user = Socialite::driver($provider)->userFromToken($input['token']);

        // return $user->name;

        $review = new \stdClass;
        $review->reviewing = [];
        $review->reviewer = [];
        $follow = new \stdClass;
        $follow->following = [];
        $follow->follower = [];


        switch ($role) {
            case 'designer':
            $new_user = User::create(
                [
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt(123456),
                'role' => [$role],
                'socialite' => [
                        [
                            'provider' => $provider,
                            'provider_id' => $user->id,
                            'name' => $user->name,
                        ]
                ],
                'profile_img' => (object)[
                        'avatar' => [$user->avatar],
                        'cover' => ['https://st.hzcdn.com/simgs/bd91d4b002fbf2b0_14-3483/contemporary-living-room.jpg', 'https://st.hzcdn.com/simgs/f1422b7d0806af97_17-3221/home-design.jpg'],
                        ],
                'review' => $review,
                'follow' => $follow,
            ]);
                break;
            case 'enduser':
            $new_user = User::create(
                [
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt(123456),
                'role' => [$role],
                'socialite' => [
                        [
                            'provider' => $provider,
                            'provider_id' => $user->id,
                            'name' => $user->name,
                        ]
                    ],
                'profile_img' => (object) [
                        'avatar' => [ $user->avatar],
                    ],
                'review' => $review,
                ]);
                break;

        }
        $this->generateURL($new_user);
        Auth::login($new_user, true);
        return redirect()->to('/home');
        // return $input;
        // return $request->input('role');
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
