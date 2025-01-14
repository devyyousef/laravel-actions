<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $this->loadMissing(['roles', 'roles.permissions']);
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }
}
