<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class NewInvoiceCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // $newinvoice
        Log::info('Showing listening for user: ');
        $to = str_replace(' ', '',$event->newinvoice->contact_phone);
        $message = $event->newinvoice->contact_name.", There is a payment invoice (".$event->newinvoice->serialcode.") for you on Smallpay. ";
        $senderid = 'TestSender';
        $token = config('services.smartsms.token');
        $routing = 3;
        $type = 0;
        $baseurl = 'https://smartsmssolutions.com/api/json.php?';
        $sendsms = $baseurl.'message='.$message.'&to='.$to.'&sender='.$senderid.'&type='.$type.'&routing='.$routing.'&token='.$token;
        $response = Http::get($sendsms);
       
    }
}
