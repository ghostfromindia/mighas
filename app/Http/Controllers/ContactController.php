<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;
use DB, Image, Validator, Session, Mail, Route;
use Illuminate\Validation\Rule;
use App\Models\HomePageSettings;
use App\Models\Support;
use App\Models\FrontendPage;

class ContactController extends Controller
{

	public function newsletter_save(Request $request)
	{
		$newsletter = new NewsletterSubscription;
        $rules = array(
            'email' => [
                'required',
                'email',
                'max:255',
			    Rule::unique('newsletter_subscriptions')->where(function($query) {
			        $query->where('unsubscribed', '=', 0);
			    })
			  ],
        );

        $messages = [
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'Email already subscribed'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $data['unsubscribed'] = 0;
        $newsletter->fill($data);
        $newsletter->save();
        return response()->json(['success'=>true]);
	}

	public function contact_us()
	{
		if(Session::has('settings_session')){
			$common_settings = Session::get('settings_session');
			$contact_data = $common_settings['footer-contact'];
		}
		else{
			$contact = HomePageSettings::where('section', 'footer-contact')->first();
			$contact_data = json_decode($contact->content);
		}
		$name = Route::currentRouteName();
        $meta_details = FrontendPage::where('slug',$name)->first();
		return view('client.contact_us', ['contact_data'=>$contact_data, 'meta_details'=>$meta_details]);
	}

	public function contact_us_save(Request $request)
	{
		$support = new Support;
		$rules = array(
			'name' => 'required|max:255',
            'email' => ['required', 'email', 'max:255'],
            'message' => 'required',
        );

        $messages = [
        	'name.required' => 'Please enter your name',
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address',
            'message.required' => 'Please enter your message',
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $support->fill($data);
        $support->save();
        Mail::to('sobha@spiderworks.in')->send(new \App\Mail\ContactUs($support));
        return response()->json(['success'=>true]);
	}
}
