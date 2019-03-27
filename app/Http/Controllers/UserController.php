<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function editUser(){
        dd(request()->id);
        $user = User::withTrashed()->get()->find(request()->id);
        $user->update([
            'email'     =>request()->email,
            'name'      =>request()->name,
            'lastname'  =>request()->lastname,
            'admin'     =>request()->admin,
        ]);
        if(request()->password != "")
            $user->password = Hash::make(request()->password);
        $user->save();
        return redirect()->back();
    }

    public function deleteUser($id){
        $user = User::get()->find($id);
        $user->delete();
        return redirect()->back();
    }

    public function restoreUser(){
        $user = User::withTrashed()->get()->find(request()->id);
        $user->restore();
        return redirect()->back();
    }
}
