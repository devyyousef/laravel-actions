<?php

namespace Modules\Setting\Actions;

use App\Http\Resources\BaseResponseResource;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Setting\Models\Setting;
use Modules\Setting\Services\SettingManagementService;

class UpdateSettingByIDAction
{
    use AsAction;
    public function handle(Request $request, Setting $setting)
    {
        $validated = $this->validate($request, $setting);
        if (!isset($validated['key'])) {
            unset($validated['key']);
        }
        $setting->update($validated);
        return new BaseResponseResource('Setting updated successfully', $setting, 200);
    }
    public function validate(Request $request, Setting $setting)
    {
        return $request->validate([
            'key' => 'nullable|string|unique:settings,key,' . $setting->id,
            'value' => 'required|string',
        ]);
    }
    public function asController(Request $request, Setting $setting)
    {
        return $this->handle($request, $setting);
    }
}
