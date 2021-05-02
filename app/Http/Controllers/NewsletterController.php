<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscribedToNewsletter;
use Illuminate\Support\Facades\Auth;
use App\Events\Newsletter\SubscriptionConfirmationEmail;

class NewsletterController extends Controller
{
	protected $mailchimp;

	/**
	 * Pull the Mailchimp-instance from the IoC-container.
	 */
	public function __construct(\Mailchimp $mailchimp)
	{
		$this->mailchimp = $mailchimp;
	}

	/**
	 * Access the mailchimp lists API
     * for more info check "https://apidocs.mailchimp.com/api/2.0/lists/subscribe.php"
	 */
	public function addEmailToList(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email|max:191'
		]);
		if(config('mailchimp.enable')) {
			try {
				$this->mailchimp
					->lists
					->subscribe(
						config('mailchimp.list_id'),
						['email' => $request->email]
					);
				session()->flash('subscribed', __('Please check your email to confirm the subscription.'));
	        } catch (\Mailchimp_List_AlreadySubscribed $e) {
	        	session()->flash('already_subscribed', __('You have already subscribed to our newsletter.'));
	        } catch (\Mailchimp_Error $e) {
	        	session()->flash('subscribe_failed', __('Unexpected error occurred! Please try again after some time.'));
	        }

		} else {
			$subscriber = Subscriber::where('email', '=', $request->email)->first();
			if ($subscriber == null) {
				$subscriber = Subscriber::create([
									'email' => $request->email,
									'active' => false,
									'activation_token' => str_random(191)
								]);

				// Newsletter Subscription Event
				event(new SubscriptionConfirmationEmail($subscriber));

				session()->flash('subscribed', __('Please check your email to confirm the subscription.'));

			} elseif(!$subscriber->active) {

				// Newsletter Subscription Event
				event(new SubscriptionConfirmationEmail($subscriber));

				session()->flash('subscribed', __('Please check your email to confirm the subscription.'));
			} else {
				session()->flash('already_subscribed', __('You have already subscribed to our newsletter.'));
			}
		}

		return redirect()->back();
	}

	public function subscribe()
	{
		return view('errors.404');
	}

	public function confirm(Request $request)
	{
    	$subscriber = Subscriber::where('email', $request->email)->where('activation_token', $request->token)->firstOrFail();
    	$subscriber->update([
    			'active' => true,
    			'activation_token' => null
			]);
		session()->flash('subscribed', __('Thank you for subscribing.'));

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

        // Send Email for Subscribed
        try {
            Mail::to($subscriber->email)->send(new SubscribedToNewsletter());
        } catch (\Exception $e) {
			return $e->getMessage();
		}

    	return redirect()->back();
	}
}
