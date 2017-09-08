<?php

namespace App\Http\Controllers;

use Hash;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function show($username)
    {
        $user = $this->user->getByName($username);
        $comments = $user->comments->take(10);

        return view('user.index', compact('user', 'comments'));
    }

    public function edit()
    {
        $user = $this->user->find(Auth::id());

        return view('user.profile', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->except(['name', 'email', 'is_admin']);

        $user = $this->user->find($id);

        $this->authorize('update', $user);

        $this->user->update($id, $input);

        return redirect()->back();
    }

    public function comments($username)
    {
        $user = $this->user->getByName($username);

        $comments = $user->comments;

        return view('user.comments', compact('user', 'comments'));
    }

    public function changePassword(Request $request)
    {
        if (!Hash::check($request->input('old_password'), Auth::user()->password)) {
            return redirect()->back()->withErrors([
                'old_password' => 'The password must be the same of current password.',
            ]);
        }

        Validator::make($request->all(), [
            'old_password' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ])->validate();;


        $this->user->changePassword(Auth::user(), $request->input('password'));
        return redirect()->back();
    }
}
