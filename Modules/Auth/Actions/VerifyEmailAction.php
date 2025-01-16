<?php

namespace Modules\Auth\Actions;

use App\Http\Resources\BaseResponseResource;
use App\Http\Resources\ErrorResponseResource;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Users\Models\User;

class VerifyEmailAction
{
    use AsAction;
    public function handle(Request $request)
    {
        $validated = $this->validate($request);
        $user = User::where('email', $validated['email'])->first();
        if ($user) {
            if ($this->isValid($validated['code'], $user)) {
                return new ErrorResponseResource('Invalid verification code', 400);
            }
            $user->markEmailAsVerified();
            return new BaseResponseResource(__('Email verified successfully'), [], 200);
        }
    }

    public function validate(Request $request)
    {
        return $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);
    }
    public function isValid($code, $user)
    {
        return $user->verification_code !== $code;
    }
    public function asController(Request $request)
    {
        return $this->handle($request);
    }
}
