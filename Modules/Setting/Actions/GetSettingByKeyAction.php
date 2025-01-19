<?php

namespace Modules\Setting\Actions;

use App\Http\Resources\BaseResponseResource;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Setting\Models\Setting;

class GetSettingByKeyAction
{
    use AsAction;
    public function handle($key)
    {
        $setting = Setting::where('key', $key)->first();
        if (!$setting) {
            abort(404);
        }
        return new BaseResponseResource('Setting Fetched Successfully', $setting, 200);
    }
    public function asController($key)
    {
        return $this->handle($key);
    }
}
