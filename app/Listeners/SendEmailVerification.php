<?php

namespace App\Listeners;

use App\Events\NewUserCreated;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerification implements ShouldQueue
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
        sleep(5);
        // $event->user->ema
        Mail::to($event->user->email)->send(new SendMail($event->user));
    }
}
