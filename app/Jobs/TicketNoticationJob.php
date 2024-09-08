<?php

namespace App\Jobs;

use App\Notifications\TicketNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class TicketNoticationJob implements ShouldQueue
{
    use Queueable;

    protected $user, $ticket, $content, $path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $ticket, $content)
    {
        $this->user = $user;
        $this->ticket = $ticket;
        $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::send($this->user, new TicketNotification($this->user, $this->ticket, $this->content));
    }
}
