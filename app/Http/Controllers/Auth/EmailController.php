<?php
namespace App\Http\Controllers\Auth;

use Mail;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    public function sendNewEmail()
    {
        $to_name = 'Valiant';
        $to_email = 'mariovunguyen@gmail.com';
        $from_email = 'mariovunguyen@gmail.com';
        $data = array('name'=>"Sam Jose", "body" => "Test mail");
            
        Mail::send('emails.email', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Artisans Web Testing Mail');
            $message->from('mariovunguyen@gmail.com','Artisans Web');
        });
        // check for failures
    if (Mail::failures()) {
        // return response showing failed emails
    }

    // otherwise everything is okay ...
    return redirect()->back();
    }
}