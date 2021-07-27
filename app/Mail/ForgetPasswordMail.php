<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user ,$settings;
    public function __construct($admin)
    {
        //
        $this->user = $admin;
        $sets = Setting::all();
        $setting = [];
        foreach($sets as $set){
            $setting[$set->name] = $set->data;
            if($set->key == 'test_count'){
               $xset = $set;
            }
        }
        $this->settings = $setting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $settings = $this->settings;
        return $this->from($settings['site_email']  ,$settings['email_sender'])->subject(trans('login.forget_password_mail' , ['site' => $settings['site_title']]))->view('admin.mail.forget_password' , [
            'settings' => $settings,
            'user' => $this->user
        ]);    
        
    }
}
