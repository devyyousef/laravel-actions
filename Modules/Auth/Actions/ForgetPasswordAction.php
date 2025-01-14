<?php

namespace Modules\Auth\Actions;

use App\Http\Resources\BaseResponseResource;
use App\Http\Resources\ErrorResponseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class ForgetPasswordAction
{
    use AsAction;
    public function handle($data)
    {
        $validated = $this->validate($data);

        $status = Password::sendResetLink($data);

        switch ($status) {
            case Password::ResetLinkSent:
                return new BaseResponseResource('Password reset link sent to your email', [], 200);

            case Password::ResetThrottled:
                return new ErrorResponseResource('Too many reset attempts. Please try again later.', 429);

            default:
                return new ErrorResponseResource('Password reset link could not be sent.', 400);
        }
    }

    public function validate($data)
    {
        try {
            $validator = validator($data, [
                'email' => 'required|email',
            ])->validate();
            return $validator;
        } catch (ValidationException $e) {
            return $e->validator->validated();
        }
    }
    public function asController(Request $request)
    {
        return $this->handle($request->all());
    }
}
