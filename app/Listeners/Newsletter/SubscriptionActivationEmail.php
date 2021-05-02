<?php

namespace App\Listeners\Newsletter;

use App\Events\Newsletter\SubscriptionConfirmationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\ConfirmNewsletterSubscription;

class SubscriptionActivationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SubscriptionConfirmationEmail  $event
     * @return void
     */
    public function handle(SubscriptionConfirmationEmail $event)
    {
        if($event->subscriber->active) {
            return;
        }

        // Change Email Carrier for this request
        if(config('subscribers.email_carrier') == 'mailgun') {
            config([
                'mail.host' => 'smtp.mailgun.org',
                'mail.driver' => config('subscribers.email_carrier')
            ]);
        }
        config([
            'mail.from.address' => config('subscribers.from.address'),
            'mail.from.name' => config('subscribers.from.name')
        ]);

        // Send Email for Newsletter Subscription Confirmation
        try {
            Mail::to($event->subscriber->email)->send(new ConfirmNewsletterSubscription($event->subscriber));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
