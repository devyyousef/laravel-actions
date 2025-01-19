<?php

namespace Modules\Setting\Actions;

use App\Http\Resources\BaseResponseResource;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Setting\Models\Setting;
use Modules\Setting\Services\SettingManagementService;

class UpdateSettingByKeyAction
{
    use AsAction;
    public function handle(Request $request, $key)
    {
        $setting = Setting::where('key', $key)->first();
        if (!$setting) {
            abort(404);
        }
        $validated = $this->validate($request, $setting);
        $setting->update($validated);
        return new BaseResponseResource('Setting updated successfully', $setting, 200);
    }
    public function validate(Request $request, Setting $setting)
    {
        return $request->validate([
            'value' => 'required|string',
        ]);
    }
    public function asController(Request $request, $key)
    {
        return $this->handle($request, $key);
    }
}
