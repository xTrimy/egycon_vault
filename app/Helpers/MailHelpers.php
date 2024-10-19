<?php

namespace App\Helpers;

use App\Exceptions\MailException;
use App\Exceptions\WrongValueException;
use App\Helpers\Models\EmailTemplate;
use App\Helpers\Models\MailMessage;
use App\Helpers\Models\Recipient;
use App\Helpers\Models\Sender;
use App\Models\EventEmailTemplate;
use App\Services\ZeptoMail\ZeptoClient;
use Barryvdh\Debugbar\Facades\Debugbar;
use Exception;
use Postmark\Models\DynamicResponseModel;
use Postmark\PostmarkClient;
use Postmark\Models\PostmarkException;
use stdClass;
use Illuminate\Support\Facades\Log;

final class MailHelpers 
{
    private static $subjects = [
        "registration" => "Hey {{name}}! Your belonging has been registered. Code: {{code}}",
    ];


    public static function send_email($data, $email, $email_template = null){

        if($email_template != null){
            $body = $email_template->getBody();
            $subject = $email_template->getSubject();
            foreach($data as $key => $value){
                $body = str_replace("{{" . $key . "}}", $value, $body);
                $subject = str_replace("{{" . $key . "}}", $value, $subject);
            }
            $message = MailMessage::builder()
                ->to(new Recipient($email, $data["name"]?? "N/A"))
                ->from(new Sender("egycon@gamerslegacy.net", "EGYCON"))
                ->subject($subject)
                ->htmlBody($body)
                ->trackOpens(true)
                ->reference("Vault @ EGYCON Halloween")
                ->tag("Vault @ EGYCON Halloween")
                ->build();
            
            $sendResult = self::sendEmail($message);
        }
    
    }


    /**
     * @param MailMessage $message
     * @return DynamicResponseModel | string | null
     * @throws MailException
     * @throws Exception
     * @throws PostmarkException
     */
    public static function sendEmail(MailMessage $message){
        if(env('ENABLE_EMAIL_SENDING', false) == false) {
            Log::channel('emails')->info(
                "Email Sending is Disabled."
                . PHP_EOL
                ."Email To Send:". 
                json_encode($message)
            );
            return null;
        }
        if(env('ENABLE_POSTMARK_EMAILS', false) == true){
            return self::sendPostMarkEmail($message);
        } else if(env('ENABLE_ZEPTO_EMAILS', true) == true){
            return self::sendZeptoMailEmail($message);
        }else{
            throw new MailException("No Email Service is enabled", 500);
        }
    } 

    public static function sendZeptoMailEmail(MailMessage $message){
        $array_message = [
            'to' => $message->getToZepto(),
            'from' => $message->getFrom(),
            'track_opens' => $message->getTrackOpens(),
            'track_clicks' => $message->getTrackClicks(),
            'subject' => $message->getSubject(),
            'htmlbody' => $message->getHtmlBody(),
            'client_reference' => $message->getReference(),
        ];
        try {
            $client = new ZeptoClient(env("ZEPTO_API_KEY"));
            return $client->sendEmail($array_message);
        } catch (Exception $ex) {
            throw new MailException("ZeptoMail Exception: " . $ex->getMessage(), 500, $ex);
        }
    }

    public static function sendPostMarkEmail(MailMessage $message){
        $array_message = [];
        foreach($message->getTo() as $recipient){
            $array_message[] = [
                'To' => $recipient->getEmail(),
                'From' => $message->getFrom()->getEmail(),
                'TrackOpens' => $message->getTrackOpens(),
                'Subject' => $message->getSubject(),
                'HtmlBody' => $message->getHtmlBody(),
                'Tag' => $message->getTag(),
                'MessageStream' => 'outbound',
            ];
        }
        try {
            $client = new PostmarkClient(env("POSTMARK_TOKEN"));
            return $client->sendEmailBatch($array_message);
            // $sendResult = $client->sendEmailWithTemplate(
            //     "egycon@gamerslegacy.net",
            //     $request->email,
            //     27132435,
            //     [
            //         "name" => explode(' ', $request->name)[0],
            //         "order_id" => $request->id,
            //     ]
            // );
        } catch (PostmarkException $ex) {
            // If the client is able to communicate with the API in a timely fashion,
            // but the message data is invalid, or there's a server error,
            // a PostmarkException can be thrown.
            throw new MailException("Postmark Exception: " . $ex->httpStatusCode . " Status returned: " . $ex->message, $ex->postmarkApiErrorCode, $ex);
        } catch (Exception $generalException) {
            throw new MailException("A general exception thrown", 500, $generalException);
            // A general exception is thrown if the API
            // was unreachable or times out.
        }
    }
    public static function getEmailTemplate($type){
        $type = strtolower($type);
        if (!in_array($type, ['registration'])) {
            throw new WrongValueException("Invalid Email Template Type: ". $type);
        }
        $email_template = new EmailTemplate(self::$subjects[$type], file_get_contents(public_path("emails/$type.html")));
        return $email_template;
    }
 
    public static function getRegistrationEmailTemplate()
    {
        return self::getEmailTemplate('registration');
    }
}
