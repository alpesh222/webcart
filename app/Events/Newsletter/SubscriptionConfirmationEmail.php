<?php

namespace App\Events\Newsletter;

use App\Subscriber;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class SubscriptionConfirmationEmail
{
    use Dispatchable, SerializesModels;

    public $subscriber;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }
}
