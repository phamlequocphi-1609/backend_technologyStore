<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\profile\RegisterRequest;
use App\Http\Requests\admin\profile\UpdateProfileRequest;
use App\Models\admin\country;
use App\Models\User;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getCountry()
    {     
       $countryData = country::all();
       return view('admin.user.add', compact('countryData'));
    }
    public function create(RegisterRequest $request)
    {
        $data = $request->all();
        $file = $request->avatar;
        
        if(!empty($file)){  
            $data['avatar'] = $file->getClientOriginalName();
            $file->move(public_path('upload/admin'), $data['avatar']);
        }
        if(User::create($data)){
            return redirect()->back()->with('success', 'Data added successfully');
        }else{
            return redirect()->back()->withErrors('Data added failed');
        }
    }
    public function profile(){
        $countryData = country::all();
        $admin = Auth::user();
        return view('admin.user.profile', compact('countryData', 'admin'));
    }
    public function update(UpdateProfileRequest $request)
    {
        $adminId = Auth::id();
        $admin = User::findOrFail($adminId);
        $data = $request->all();
        $file = $request->avatar;
        if(!empty($file)){
            $data['avatar'] = $file->getClientOriginalName();
        }
        if($data['password']){
            $data['password'] = bcrypt($data['password']);
        }else{
            $data['password'] = $admin->password;
        }
        if($admin->update($data)){
            if(!empty($file)){
                $file->move(public_path('upload/admin'), $file->getClientOriginalName());
            }
            return redirect()->back()->with('success', 'Data updated successfully');
        }else{
            return redirect()->back()->withErrors('Data updated failed');
        }
    }
}