<?php

namespace App\Listeners;

use App\Events\NewUserCreated;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerification
{

    public $user;
    /**
     * Create the event listener.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     */
    public function handle(NewUserCreated $event): void
    {
        // $event->user->ema
        Mail::to($event->user->email)->send(new SendMail($event->user));
    }
}
