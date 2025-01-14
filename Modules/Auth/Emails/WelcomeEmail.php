<?php

namespace Modules\Auth\Emails;

use Modules\Users\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->view('auth::emails.welcome', [
            'name' => $this->user->name,
        ]);
    }
}
