<?php

namespace Modules\Users\Actions;

use App\Http\Resources\BaseResponseResource;
use Illuminate\Http\Client\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Permission\Models\Role;

class GetPermissionsByRoleAction
{
    use AsAction;
    public function handle($id)
    {
        return Role::findOrFail($id)->permissions;
    }
    public function asController($id)
    {
        $permissions = $this->handle($id);
        return new BaseResponseResource('Permissions Retrieved Successfully', $permissions);
    }
}
