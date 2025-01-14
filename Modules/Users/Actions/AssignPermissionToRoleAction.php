<?php

namespace Modules\Users\Actions;

use App\Http\Resources\BaseResponseResource;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Users\Transformers\RoleResource;
use Spatie\Permission\Models\Role;

class AssignPermissionToRoleAction
{
    use AsAction;

    public function assignSingle(Request $request, Role $role)
    {
        $validated = $this->validate($request, 'single');
        $role->givePermissionTo($validated['permission']);
        return new BaseResponseResource(__('Role permissions updated successfully'), RoleResource::make($role));
    }
    public function syncMultiple(Request $request, Role $role)
    {
        $validated = $this->validate($request, 'multiple');
        $role->syncPermissions($validated['permissions']);

        return new BaseResponseResource(__('Role permissions updated successfully'), RoleResource::make($role));
    }
    public function validate($request, $type)
    {
        $single = [
            'permission' => 'required|string|exists:permissions,name',
        ];
        $multiple = [
            'permissions' => 'required|array',
            'permissions.*' => 'required|string|exists:permissions,name',
        ];

        return $request->validate($type === 'single' ? $single : $multiple);
    }
}
