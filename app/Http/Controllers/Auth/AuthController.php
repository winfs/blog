<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use Validator;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        $user = $this->user->getByGithubId($githubUser->id);

        // 检查用户是否登录
        if (auth()->check()) {
            $currentUser = auth()->user();

            // github帐号已被其他用户绑定或当前用户已绑定github帐号
            if ($user || $currentUser->github_id) {
                return redirect()->back();
            }

            // 开始绑定
            $this->bindGithub($currentUser, $githubUser);
            return redirect()->back();
        } else {
            if ($user) {
                // 让绑定的用户直接登录
                auth()->loginUsingId($user->id);
                return redirect('/');
            } else {
                // 一个全新的用户来了，开始注册
                $this->registerUser($githubUser);
                return redirect()->to('auth/github/register');
            }
        }
    }

    public function bindGithub($currentUser, $githubUser)
    {
        $currentUser->github_id = $registerData->user['id'];
        $currentUser->github_name = $registerData->nickname;
        $currentUser->github_url = $registerData->user['url'];

        $currentUser->save();
    }

    public function registerUser($registerData)
    {
        $data['avatar'] = $registerData->user['avatar_url'];
        $data['github_id'] = $registerData->user['id'];
        $data['github_name'] = $registerData->nickname;
        $data['github_url'] = $registerData->user['url'];
        $data['name'] = $registerData->nickname;
        $data['nickname'] = $registerData->user['name'];
        $data['email'] = $registerData->user['email'];

        session()->put('oauthData', $data);
    }

    /**
     * 展示 github outh 注册页面
     */
    public function create()
    {
        if (!session()->has('oauthData')) {
            return redirect()->to('login');
        }

        $oauthData = array_merge(session('oauthData'), request()->old());

        return view('auth.github_register', compact('oauthData'));
    }

    /**
     * 注册一个新用户
     */
    public function store(Request $request)
    {
        if (!session()->has('oauthData')) {
            return redirect('login');
        }

        $request = $request->all();
        $this->validator($request)->validate();

        $oauthData = session('oauthData');

        $data = array_merge($oauthData, $request);

        $data['password'] = bcrypt($data['password']);
        $data['status'] = true;

        auth()->guard()->login(User::create($data));

        session()->forget('oauthData');

        return redirect('/');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|min:3|max:16|unique:users|regex:/^[0-9a-zA-Z-_]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
}
