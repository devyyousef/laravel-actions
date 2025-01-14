<?php

namespace Modules\Users\Actions;

use App\Http\Resources\BaseResponseResource;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Users\Transformers\UserResource;

class GetUserAction
{
    use AsAction;
    public function asController()
    {
        $user = auth('sanctum')->user();
        return new BaseResponseResource('User data', UserResource::make($user), 200);
    }
}
