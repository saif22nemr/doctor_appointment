<?php
namespace App\Http\Traits;

use App\Mail\Template;
use App\Models\EmailTemplate;
use App\Models\Setting;
use App\Models\User as ModelsUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;


/**
 *  This trait will content all methods that dealing with api and paginate pages too.
 */
trait EmailHandling
{
	private $person;
    private $template;
    private $languageuage;
    private $data;
    

    /**
     * Execute the job.
     *
     * @return void
     */
    public function setConfigMail(){
        $settings = Setting::all();
        $setting =[];
        foreach($settings as $set):
            $setting[$set->key] = $set->value;
        endforeach;
        Config::set('mail.mailers.smtp.username', trim($setting['email']));    
        Config::set('mail.mailers.smtp.host', trim($setting['email_host']));    
        Config::set('mail.mailers.smtp.port', trim($setting['email_port']));    
        Config::set('mail.mailers.smtp.encryption', trim('ssl'));    
        Config::set('mail.default', trim('smtp'));    
        Config::set('mail.mailers.smtp.password', trim($setting['email_password']));
        config(['MAIL_USERNAME'=> trim($setting['email'])]);    
        config(['MAIL_HOST'=> trim($setting['email_host'])]);    
        config(['MAIL_PORT'=> trim($setting['email_port'])]);    
        config(['MAIL_MAILER'=> trim('smtpx')]);    
        config(['MAIL_ENCRYPTION'=> trim('ssl')]);    
        config(['MAIL_PASSWORD'=> trim($setting['email_password'])]);
        $configuration = [
            'smtp_host'    => trim($setting['email_host']),
            'smtp_port'    => trim($setting['email_port']),
            'smtp_username'  => trim($setting['email']),
            'smtp_password'  => trim($setting['email_password']),
            'smtp_encryption'  => 'SMTP-ENCRYPTION-HERE',
           
            'from_email'    => 'FROM-EMAIL-HERE',
            'from_name'    => 'FROM-NAME-HERE',
           ];
           
        //    $mailer = app()->makeWith('user.mailer', $configuration);
    }
    public function sendMessageTemplate(ModelsUser $user, EmailTemplate $template ,Array $data){
        $this->setConfigMail();
        $content = $this->emailAttributes($data , $template);
        
        if($template->email_status == 1){
            Mail::to($user)->send(new Template($user , $content));
        }
        
        if($template->sms_status){
            $this->sendSms($user->phone , $content['sms_body']);
        }
    }
    protected function emailAttributes($attribute , $template){
        $body  = [
            'email_subject' => $template->subject,
            'email_body' => $template->body,
            'sms_body' => $template->sms_body,
        ];
        foreach ($attribute as $key => $value) {
            $body['email_subject'] = str_replace($key, $value, $body['email_subject']);
            $body['email_body'] = str_replace($key, $value, $body['email_body']);
            $body['sms_body'] = str_replace($key, $value, $body['sms_body']);
        }
        return $body;
    }
    public function sendSms($number, $message){
        $set = Setting::all();
        $setting = [];
        foreach ($set as $key => $s) {
            $setting[$s->key] = $s->value;
        }
        $url = trim($setting['sms_url']);
        $personname = trim($setting['sms_number']);
        $password = trim($setting['sms_password']);
        $tagname = trim($setting['sms_sender']);
        $active = trim($setting['sms_status']);
        $message = trim($message);
        $message = urlencode($message);
        if($active == 0)  return false;
        //$ur = $url.'?Username='.$personname.'&Password='.$password.'&Tagname='.$tagname.'&VariableList=0&ReplacementList=&RecepientNumber='.$number.'&Message="'.$message.'"&SendDateTime=0&EnableDR=false&SentMessageID=true';
        // $d = callAPI('GET', $url,false);
        $ur = $url.'username='.$personname.'&password='.$password.'&Tagname='.$tagname.'&RecepientNumber='.$number.'&VariableList=&ReplacementList=&Message='.$message.'&SendDateTime=0&EnableDR=false&SentMessageID=true';
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $ur);
           curl_setopt($handle, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
           ));
           curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
        $d = curl_exec($handle);
        curl_close($handle);                
        return $d;
      }
 
}

