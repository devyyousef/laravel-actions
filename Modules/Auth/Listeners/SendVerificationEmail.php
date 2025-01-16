<?php

namespace Modules\Auth\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Emails\VerifyEmail;
use Modules\Auth\Emails\WelcomeEmail;
use Modules\Users\Models\User;

class SendVerificationEmail
{
    public function handle(User $user): void
    {
        $user->sendEmailVerificationNotification();
    }
}
