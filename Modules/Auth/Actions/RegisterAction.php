<?php

namespace Modules\Auth\Actions;

use  Modules\Users\Models\User;
use App\Http\Resources\BaseResponseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Auth\Events\RegisterEvent;
use Modules\Users\Transformers\UserResource;

class RegisterAction
{
    use AsAction;
    public function handle($data)
    {
        $validated = $this->validate($data);

        $user = User::where('email', $validated['email'])->first();
        if ($user) {
            $user->delete();
        }

        $user = User::create([
            'name'   => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        Event::dispatch(RegisterEvent::class, $user);

        return UserResource::make($user);
    }
    public function validate($data)
    {
        try {
            return validator($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ])->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $e->validator->validated();
        }
    }
    public function asController(Request $request)
    {
        $user = $this->handle($request->all());
        return new BaseResponseResource('User registered successfully', $user, 200);
    }
}
