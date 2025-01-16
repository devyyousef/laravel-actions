<?php

namespace Modules\Auth\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Modules\Users\Models\User;

class GenerateVerificationCode
{
    public function handle(User $user): void
    {
        $code = rand(100000, 999999);
        $user->verification_code = $code;
        $user->save();
    }
}
