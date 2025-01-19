<?php

namespace Modules\Setting\Actions;

use App\Http\Resources\BaseResponseResource;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Setting\Models\Setting;
use Modules\Setting\Services\SettingManagementService;

class CreateSettingAction
{
    use AsAction;
    public function handle(Request $request)
    {
        $validated = $this->validate($request);
        $newSetting = Setting::create($validated);
        return new BaseResponseResource('Setting created successfully', $newSetting, 200);
    }
    public function validate(Request $request)
    {
        return $request->validate([
            'key' => 'required|string|unique:settings,key',
            'value' => 'required',
        ]);
    }
    public function asController(Request $request)
    {
        return $this->handle($request);
    }
}
