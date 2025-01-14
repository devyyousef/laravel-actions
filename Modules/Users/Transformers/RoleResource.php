<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $role = $this->loadMissing('permissions');
        return [
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => $role->permissions,
        ];
    }
}
