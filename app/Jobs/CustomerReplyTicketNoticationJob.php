<?php

namespace App\Jobs;

use App\Notifications\CustomerReplyTicketNotication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class CustomerReplyTicketNoticationJob implements ShouldQueue
{
    use Queueable;

    protected $user, $detail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $detail)
    {
        $this->user = $user;
        $this->detail = $detail;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::send($this->user, new CustomerReplyTicketNotication($this->detail));
    }
}
