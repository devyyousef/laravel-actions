<?php

namespace Modules\Auth\Actions;

use App\Http\Resources\BaseResponseResource;
use App\Http\Resources\ErrorResponseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Users\Transformers\UserResource;

class LoginAction
{
    use AsAction;
    public function handle($data)
    {
        $validated = $this->validate($data);
        if (Auth::attempt($validated)) {
            $user = Auth::guard('sanctum')->user();
            if (!$user->hasVerifiedEmail()) {
                return new ErrorResponseResource('Email not verified', 400);
            }
            $accessToken = $user->createToken('authToken')->plainTextToken;
            $data = ['access_token' => $accessToken, 'user' => UserResource::make($user)];
            return new BaseResponseResource('Login successfully', $data, 200);
        }
    }
    public function validate($data)
    {
        return validator($data, [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();
    }
    public function asController(Request $request)
    {
        return $this->handle($request->all());
    }
}
