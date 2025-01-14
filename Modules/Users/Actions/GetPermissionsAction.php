<?php

namespace Modules\Users\Actions;

use App\Http\Resources\BaseResponseResource;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Permission\Models\Permission;

class GetPermissionsAction
{
    use AsAction;
    public function handle()
    {
        return Permission::all();
    }

    public function asController()
    {
        $permissions = $this->handle();
        return new BaseResponseResource('Permissions Retrieved Successfully', $permissions, 200);
    }
}
