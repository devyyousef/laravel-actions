<?php

namespace Modules\Auth\Listeners;

use Modules\Users\Models\User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Emails\WelcomeEmail;
use Modules\Auth\Events\RegisterEvent;

class SendWelcomeEmail
{
    public function handle(User $user): void
    {
        Mail::to($user->email)->send(new WelcomeEmail($user));
    }
}
