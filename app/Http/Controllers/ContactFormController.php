<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function submit(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        $to_name = 'Valiant';
        $to_email = 'mariovunguyen@gmail.com';
        $from_email = $request->email;
        $from_name = $request->name;
        $data = array('name'=>$to_name, "body" => $request->message);
            
        Mail::send('emails.email', $data, function($message) use ($to_name, $to_email, $from_email, $from_name) {
            $message->to($to_email, $to_name)
                    ->subject('Artisans Web Testing Mail');
            $message->from($from_email, $from_name);
        });
        // check for failures
        if (Mail::failures()) {
            // return response showing failed emails
        }

        // otherwise everything is okay ...
        return response()->json(null, 200);
    }
}
