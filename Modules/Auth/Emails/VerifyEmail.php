<?php

namespace Modules\Auth\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Users\Models\User;

class VerifyEmail extends Mailable
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
        return $this->view('auth::emails.verify_email', [
            'verification_code' => $this->user->verification_code,
        ]);
    }
}
