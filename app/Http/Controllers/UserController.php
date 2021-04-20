<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public $isEdit = false;

    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(StoreUserRequest $userRequest)
    {
        $user = $userRequest->validated() ;
        $user['password'] = bcrypt($userRequest->input('password'));
        $user = User::create($user);
        return redirect()->route('admin.users.index')
            ->with('status', 'کاربر ' . $user->name . ' با موفقیت ایجاد شد');
    }

    public function edit(User $user)
    {
        $this->isEdit = true;
        return view('admin.user.create', [
            'user' => $user,
            'isEdit' => $this->isEdit,
        ]);
    }

    public function update(UpdateUserRequest $userRequest, User $user)
    {
        $user->update($userRequest->validated());
        return redirect()->route('admin.users.index')
            ->with('status', 'کاربر ' . $user->name . ' با موفقیت ویرایش شد');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
