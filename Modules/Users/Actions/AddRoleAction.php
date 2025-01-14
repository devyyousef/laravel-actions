<?php

namespace Modules\Users\Actions;

use App\Http\Resources\BaseResponseResource;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Users\Transformers\RoleResource;
use Spatie\Permission\Models\Role;

class AddRoleAction
{
    use AsAction;
    public function handle(Request $request)
    {
        $validated = $this->validate($request);
        $validated['guard_name'] = 'web';
        return Role::create($validated);
    }

    public function validate($request)
    {
        return $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);
    }
    public function asController(Request $request)
    {
        $new_role = $this->handle($request);
        return new BaseResponseResource('Role created successfully', RoleResource::make($new_role));
    }
}
