<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigProvidor extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $sets = Setting::all();
        $setting = [];
        foreach($sets as $set){
            $setting[$set->name] = $set->data;
            
        }
        Config::set('mail.mailers.smtp.username', trim($setting['email']));    
        Config::set('mail.mailers.smtp.host', trim($setting['email_host']));    
        Config::set('mail.mailers.smtp.port', trim($setting['email_port']));    
        Config::set('mail.mailers.smtp.encryption', trim('ssl'));    
        Config::set('mail.default', trim('smtp'));    
        Config::set('mail.mailers.smtp.password', trim($setting['email_password']));
    }
}
