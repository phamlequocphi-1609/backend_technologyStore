<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\MemberLoginRequest;
use App\Http\Requests\api\MemberRequest;
use App\Http\Requests\api\MemberUpdateRequest;
use App\Models\admin\country;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
class MemberApiController extends Controller
{
    public $successStatus = 200;
    public function login(MemberLoginRequest $request)
    {
        $login = [
            'email'=>$request->email,
            'password'=>$request->password,
            'level'=> 0
        ];
        $remember = false;
        if($request->remember_me)
        {
            $remember = true;
        }
        if($this->doLogin($login, $remember))
        {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status'=>'success',
                'token'=>$token,
                'Auth'=>$user
            ], $this->successStatus);
        }else{
            return response()->json([
                'response'=>'error',
                'errors'=>['errors' => 'invalid email or password'],
            ],JsonResponse::HTTP_BAD_REQUEST);
        }
    }
    protected function doLogin($attempt, $remember)
    {
        if(Auth::attempt($attempt, $remember)){
            return true;
        }else{
            return false;
        }
    }
    public function register(MemberRequest $request)
    {   
        $data = $request->all();
        $image = $request->file('avatar');
        if($image)
        {
            $name = time() . '.' .$image->getClientOriginalExtension();
            $data['avatar'] = $name;
        }
        $data['password'] = bcrypt($data['password']);
        $data['level'] = 0;
        $data['id_country'] = $data['country'];
        if($setUser = User::create($data))
        {
            if($image){
                $path = public_path('upload/api/member/' . $data['avatar']);
                Image::make($image->getRealPath())->save($path);
            }
            return response()->json([
                'status'=>'success',
                 $setUser
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'error'=>'error server',
            ],JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    public function update(MemberUpdateRequest $request, string $id)
    {
        $userId = User::findOrFail($id);
        $userData = $request->all();
        $getEmail = User::all()->where('email','=',$userData['email'])->where('id','<>',$id)->first();
        if($getEmail){
            $getEmail->toArray();
            return response()->json([
                'error'=>['error'=>'The email already exists'],
                'email'=>$getEmail['email']
            ],JsonResponse::HTTP_OK);
        }
        $file = $request->avatar;
        if($file){
            $img = $file;
            if(strpos($img,';')){
                $name = time().'.' . explode('/', explode(':', substr($img, 0, strpos($img, ';')))[1])[1];
                $userData['avatar'] = $name;
            }
        }else{
            $userData['avatar'] = $userId->avatar;
        }
        if($userData['password']){
            $userData['password'] = bcrypt($userData['password']);
        }else{
            $userData['password'] = $userId->password;
        }
        if($userId->update($userData)){
            if(strpos($file,';')){
                Image::make($file)->save(public_path('upload/api/member/').$userData['avatar']);
            }
            $userData['id'] = $id;
            $token = $userId->createToken('authToken')->plainTextToken;
            return response()->json([
                'response'=>'success',
                'token'=>$token,
                'Auth'=>$userData
            ],$this->successStatus);
        }else{
            return response()->json([
                'error'=>'error update' 
            ],JsonResponse::HTTP_BAD_REQUEST);
        }
    }
    public function country(){
        $country = country::all()->toArray();
        return response()->json([
            'status'=>'success',
            'data'=> $country,
         ],$this->successStatus);
    }
}