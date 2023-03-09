<?php

namespace App\Handler;


use App\Models\Webhook;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class WebhookHandler extends ProcessWebhookJob
{

    public function handle()
    {
        $object = json_decode($this->webhookCall, true)['payload'];


        if(isset($object['data']['order'])) {
            $startTime = strtotime($object['data']['order']['products'][0]['start_date']);
            $endTime = strtotime($object['data']['order']['products'][0]['end_date']);

            $cancellation_link = str_replace('/cancel/', '/manage-subscription/', $object['data']['subscription']['cancellation_link']);
            Webhook::create([
                'product_name' => $object['data']['order']['products'][0]['title'],
                'product_price' => $object['data']['order']['amount_total'],
                'currency' => $object['data']['order']['currency'],
                'payment_method' => $object['data']['order']['payment_method'],
                'cancellation_link' => $cancellation_link,
                'status' => $object['data']['subscription']['status'],
                'start_time' => $startTime,
                'end_time' => $endTime,
                'payer_email' => $object['data']['order']['customer']['addresses']['billing'][0]['email'],
            ]);
        }

        // Return a success message
        return response()->json(['message' => 'Webhook processed successfully'], 200);
    }

}
