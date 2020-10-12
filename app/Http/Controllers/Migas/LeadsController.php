<?php

namespace App\Http\Controllers\Migas;

use App\Models\Key;
use App\Models\Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadsController extends Controller
{
    public function common_popup(Request $request){
        if($request->form != 'common-popup' && $request->form != 'blog-enquiry' && $request->form != 'event-enquiry' && $request->form != 'contact-us-page' && $request->form != 'need-help'){abort(500);}
        if($request->type != 'lead'){abort(500);}
        $support = new Support();
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
            return json_encode(['errors'=>$validator->errors()->all()]);
        }
        $support->fill($data);
        $support->save();
        $mails = explode(',',Key::get('admin-email'));
        Mail::to($mails)->send(new \App\Mail\ContactUs($support));
        session()->put($request->form,'off');
        return json_encode(['success'=>true]);
    }
}
