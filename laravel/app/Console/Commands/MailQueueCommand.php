<?php

namespace App\Console\Commands;

use App\Jobs\EmailJob;
use Illuminate\Console\Command;

class MailQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:queue {--key=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch email queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        EmailJob::dispatch($this->option('key'));
    }
}
