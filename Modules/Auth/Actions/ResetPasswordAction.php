<?php

namespace Modules\Auth\Actions;

use App\Http\Resources\BaseResponseResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Users\Models\User;

class ResetPasswordAction
{
    use AsAction;
    public function handle($data)
    {
        $validated = $this->validate($data);

        $status = Password::reset(
            $validated,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                ])->save();
            }
        );
        return $status === Password::PasswordReset
            ? new BaseResponseResource('Password reset successfully', [], 200)
            : new BaseResponseResource('Password reset failed', [], 400);
    }
    public function validate($data)
    {
        try {
            $validator = validator($data, [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required'
            ])->validate();
            return $validator;
        } catch (ValidationException $e) {
            throw $e;
        }
    }
    public function asController(Request $request, $token)
    {
        $data = $request->all();
        $data['token'] = $token;
        return $this->handle($data);
    }
}
