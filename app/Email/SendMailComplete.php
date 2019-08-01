<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewPasswordComplete extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param $phone
     * @param $password
     * @param null $name
     */
    public function __construct($phone, $password, $name = null)
    {
        $this->phone = $phone;
        $this->password = $password;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('パスワード再発行 | 電話占いカリヨン')
            ->view('app.member.auth.sendNewPassCompleteMail')->with([
                'phone' => $this->phone,
                'password' => $this->password,
                'name' => $this->name
            ]);
    }
}