<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if($this->checkEmail($request->email) == 1) {
            $response_data = new \stdClass();
            $error = ['status' => false ,'message'=> "User with same Email ID already exist. Please use different email.", 'data' => $response_data];
            return response()->json($error);
            // return $this->sendResponse($success, 'User register successfully.');
          }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;
        $success['created_at'] =  $user->created_at;
        $success['updated_at'] =  $user->updated_at;
        $success['token'] =  $user->createToken('MyApp')->accessToken;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // $request->name = 'admin';
        // $request->password = '12345678';
        // dd($request->name);
        $loginData = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);
        if(Auth::attempt(['name' => $request->name, 'password' => $request->password])){
            $user = Auth::user();
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            $success['created_at'] =  $user->created_at;
            $success['updated_at'] =  $user->updated_at;
            $success['token'] =  auth()->user()->createToken('authToken')->accessToken;
            $user= auth()->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->accessToken;
            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        // Pass true to force the token to be blacklisted "forever"
        auth()->logout(true);
        return response()->json(['status' => 200,'message'=>'User logout successfully..!']);
    }

    public function checkEmail($email){
        $cond = ['email'=>$email];
        return User::where($cond)->count();
    }
}