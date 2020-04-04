<?php

namespace App\Channels;
use App\Channels\Messages\SmartMessage;
use Illuminate\Notifications\Notification;

class SmartChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // $message = $notification->toSmart($notifiable);

        $to = $notifiable->routeNotificationFor('Smart');
        
        $message = 'Test message now';
        $senderid = 'TestSender';
        $token = config('services.smartsms.token');
        $baseurl = 'https://smartsmssolutions.com/api/json.php?';

        $sms_array = array 
        (
        'sender' => $senderid,
        'to' => $to,
        'message' => $message,
        'type' => '0',
        'routing' => 3,
        'token' => $token
        );

        $params = http_build_query($sms_array);
        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_URL,$baseurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $response = curl_exec($ch);

        curl_close($ch);
        
        // Send notification to the $notifiable instance...
    }
}