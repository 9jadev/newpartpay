<?php

namespace App\Channels;

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
        $message = $notification->toSmart($notifiable);

        $to = $notifiable->routeNotificationFor('Smart');
        
        $message = 'Test message';
        $senderid = 'Test_Sender';
        $token = 'epQbVa1sa5rz3Esj8A6T0wy4VtWWkl1cDgBLOFe22MOPTJMB45vRN1N8enX8vFBLWZwDfWw2fyVcVnUBOt4BmdvwyAZMhHarFtrq';
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