<?php

namespace Modules\Setting\Actions;

use App\Http\Resources\BaseResponseResource;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Setting\Models\Setting;

class GetSettingByIDAction
{
    use AsAction;
    public function handle(Setting $setting)
    {
        return new BaseResponseResource('Setting Fetched Successfully', $setting, 200);
    }
}
