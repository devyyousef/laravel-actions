<?php

namespace Modules\Users\Actions;

use App\Http\Resources\BaseResponseResource;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Users\Transformers\RoleResource;
use Spatie\Permission\Models\Role;

class GetRolesAction
{
    use AsAction;

    public function handle()
    {
        return Role::all();
    }
    public function asController()
    {
        $roles = $this->handle();
        return new BaseResponseResource('Roles retrieved successfully', RoleResource::make($roles), 200);
    }
}
