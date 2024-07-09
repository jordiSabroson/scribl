<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Reminder;

class SendReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        
        $reminders = Note::whereDate('reminder', $today)->get();

        foreach ($reminders as $reminder) {
            $userEmail = $reminder->user->email;
            // Envía el correo electrónico de recordatorio
            Mail::to($userEmail)->send(new Reminder($reminder));
        }
    }
}
