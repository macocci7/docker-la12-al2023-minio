<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Address;

class MailSendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {--key=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Mail::raw('Hello!', function (Message $message) {
            $message->to([new Address('hoge@example.com', 'Mr. Hoge')])
                ->from([new Address('test@example.com', 'Test User')])
                ->subject('Test Mail' . $this->option('key'));
        });
    }
}
