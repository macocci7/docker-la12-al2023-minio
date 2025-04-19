<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Address;

class EmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string|null $key = null)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::raw('Hello!', function (Message $message) {
            $message->to([new Address('hoge@example.com', 'Mr. Hoge')])
                ->from([new Address('test@example.com', 'Test User')])
                ->subject('Test Mail Queue' . $this->key);
        });
    }
}
