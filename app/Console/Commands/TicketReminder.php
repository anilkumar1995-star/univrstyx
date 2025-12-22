<?php

namespace App\Console\Commands;

use App\Helpers\CommonHelper;
use App\Helpers\WhatsAppSend;
use App\Http\Controllers\IYDABillPayController;
use App\Models\GlobalConfig;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TicketReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticketreminder:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send whatsapp and email reminder of tickets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $check= WhatsAppSend::Send('support_ticket_resolved_and_ticket_close', '91'.env('ADMIN_MOBILE_NO'));
        $this->info("Send message");
    }
}
