<?php

namespace Modules\Setting\Actions;

use App\Http\Resources\BaseResponseResource;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Setting\Models\Setting;
use Modules\Setting\Services\SettingManagementService;

class GetSettingsAction
{
    use AsAction;
    public function handle()
    {
        $settings = Setting::all();
        return new BaseResponseResource('Settings Fetched Successfully', $settings, 200);
    }
    public function asController()
    {
        return $settings = $this->handle();
    }
}
