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

            $accessToken = $user->createToken('authToken')->plainTextToken;
            return ['access_token' => $accessToken, 'user' => UserResource::make($user)];
        }
        throw ValidationException::withMessages([
            'email' => 'The provided credentials are incorrect.'
        ]);
    }
    public function validate($data)
    {
        try {
            return validator($data, [
                'email' => 'required|email',
                'password' => 'required'
            ])->validate();
        } catch (ValidationException $e) {
            return $e->validator->validated();
        }
    }
    public function asController(Request $request)
    {
        $data = $this->handle($request->all());
        return new BaseResponseResource('User logged in successfully', $data, 200);
    }
}
