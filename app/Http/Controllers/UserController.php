<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Roles;

class UserController extends Controller
{
    public function getAll()
    {
        $users = User::orderByDesc('id')->paginate(10);
        $roles = Roles::all();
        return view('admin.user.all', ['users' => $users, 'roles' => $roles]);
    }

    public function getAdd()
    {
        return view('admin.user.add');
    }

    public function postAdd(Request $request)
    {
        $user = new User();

        $this->validate($request, [
            'email' => 'unique:users,email',
        ], [
            'email.unique' => 'Please choose another email',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);

        $user->save();

        return redirect('admin/user/all')->with('Notice', 'User added successfully');
    }

    public function getDelete($id)
    {
        User::find($id)->delete();
        return redirect('admin/user/all')->with('Notice', 'Product user delete successfully');
    }

    public function getEdit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', ['user' => $user]);
    }

    public function postEdit($id, Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'unique:categories,email,' . $id,
            ],
            [
                'email.unique' => 'Please choose another email',
            ]
        );
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect('admin/user/all')->with('Notice', 'User ' . $request->name . ' update successfully!');
    }

    public function assignRoles(Request $request)
    {
        $data = $request->all();
        $user = User::where('email', $data['email'])->first();
        $user->roles()->detach();

        $roles = Roles::all();
        foreach ($roles as $role) {
            if ($request[$role->name]) {
                $user->roles()->attach(Roles::where('name', $role->name)->first());
            }
        }
        return redirect()->back();
    }
}
