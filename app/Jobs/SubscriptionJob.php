<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requestBody;

    public function __construct($item)
    {
        $this->requestBody = [
            'ProductName' => $item['name'],
            'Price' => $item['price'],
            'Timestamp' => Carbon::now()->toDateTimeString()
        ];
    }

    public function handle()
    {
        Log::info(['calling very-slow-api... ' => $this->requestBody]);

        $response = Http::post(
            'https://very-slow-api.com/orders',
            $this->requestBody
        );

        $responseBody = json_decode((string) $response->getBody(), true);

        Log::info(['very-slow-api: ' => $responseBody]);
    }
}
