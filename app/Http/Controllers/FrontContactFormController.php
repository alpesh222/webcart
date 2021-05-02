<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsEmail;
use Validator;

class FrontContactFormController extends Controller
{
	public function contactForm()
	{
		return view('front.contact');
	}

	public function sendEmail(Request $request)
	{
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required',
            'security_code' => 'required',
            'message' => 'required'
        ]);

        if((strtolower(session()->get('captcha_code')) != strtolower($request->security_code))) {
            $validator = Validator::make([], []);
            $validator->errors()->add('security_code', 'Invalid security code.');
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $message = $request->message;
        $address = config('settings.contact_email');
        $email = $request->email;
        $name = $request->name;

        // Send Email
        try {
            Mail::to($address)->send(new ContactUsEmail($message, $email, $name));
			session()->flash('message_sent', __("Thank you for contacting us. We will get back to you as soon as possible."));
        } catch (\Exception $e) {
			session()->flash('message_not_sent', __("Sorry, your message was not sent. Please try again after some time."));
        }

		return redirect()->back();
	}
}
