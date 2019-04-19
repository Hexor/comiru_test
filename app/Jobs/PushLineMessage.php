<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushLineMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        //
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $formatMessage = [
            'to' => [$this->message['to']],
            "messages" => [
                [
                    "type" => "text",
                    "text" => $this->message['body']
                ]
            ]
        ];
        $http = new Client();
        $postContent = [
            'body' => json_encode($formatMessage),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('LINE_BOT_TOKEN')
            ]
        ];

        $http->post('https://api.line.me/v2/bot/message/multicast', $postContent);
    }
}
