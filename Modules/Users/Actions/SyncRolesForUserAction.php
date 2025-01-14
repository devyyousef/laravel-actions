<?php

namespace Modules\Users\Actions;

use App\Http\Resources\BaseResponseResource;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Users\Models\User;
use Modules\Users\Transformers\UserResource;
use Throwable;

class SyncRolesForUserAction
{
    use AsAction;
    public function handle(Request $request)
    {
        $validated = $this->validate($request);
        $roles = $validated['roles'] ?? null;
        $user = User::find($validated['user_id']);
        if (!$roles) {
            $user->roles()->detach();
            return $user;
        }
        $user->syncRoles($roles);

        return $user;
    }

    public function validate(Request $request)
    {
        return $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'nullable|array',
            'roles.*' => 'required|string|exists:roles,name',
        ]);
    }
    public function asController(Request $request)
    {
        try {
            $user = $this->handle($request);
            return new BaseResponseResource('Roles synced successfully', UserResource::make($user));
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
