<?php

namespace App\Http\Controllers\Migas;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;

class ContactController extends Controller
{
    public function newsletter_save(Request $request)
    {
        $newsletter = new NewsletterSubscription();
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
        session()->put('subscribed','subscription started');
        return response()->json(['success'=>true]);
    }
}
