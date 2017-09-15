<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;

class UserController extends ApiController
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate();

        return $this->response->paginator($users, new UserTransformer());
    }

    /**
     * 更新用户状态
     *
     */
    public function status(Request $request, $id)
    {
        if (auth()->user() == $id || $this->user->find($id)->is_admin) {
            return $this->response->errorUnauthorized('You can\'t delete for yourself and other Administrators!');
        }

        $this->user->updateColumn($id, [
            'status' => $request->input('status'),
        ]);

        return $this->response->withNoContent();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = array_merge($request->all(), [
            'password' => bcrypt($request->input('password')),
            'confirm_code' => str_random(64),
        ]);

        $this->user->store($data);

        return $this->response->withNoContent();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);

        return $this->response->item($user, new UserTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->user->update($id, $request->all());

        return $this->response->withNoContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user() == $id || $this->user->find($id)->is_admin) {
            return $this->response->errorUnauthorized('You can\'t delete for yourself and other Administrators!');
        }

        $this->user->delete($id);

        return $this->response->withNoContent();
    }
}
