<?php

namespace Modules\Auth\Actions;

use App\Http\Resources\BaseResponseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Auth\Events\ResendVerifyEmailEvent;
use Modules\Users\Models\User;

class ResendVerifyEmailAction
{
    use AsAction;
    public function handle(Request $request)
    {
        $this->validate($request);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $newCode = rand(100000, 999999);
            $user->verification_code = $newCode;
            $user->save();
            Event::dispatch(ResendVerifyEmailEvent::class, $user);
        }
        return new BaseResponseResource(__('Verification email sent successfully'), 200);
    }
    public function validate(Request $request)
    {
        return $request->validate([
            'email' => 'required|email',
        ]);
    }
    public function asController(Request $request)
    {
        return $this->handle($request);
    }
}
