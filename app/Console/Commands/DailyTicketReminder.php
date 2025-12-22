<?php

namespace App\Console\Commands;

use App\Helpers\CommonHelper;
use App\Helpers\WhatsAppSend;
use App\Http\Controllers\IYDABillPayController;
use App\Http\Mail\DailyTicketReportMail;
use App\Models\AssignTicket;
use App\Models\GlobalConfig;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DailyTicketReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyticketreminder:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily send whatsapp and email reminder of tickets';

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
    $today = date('Y-m-d');

    $assignedUsers = AssignTicket::whereDate('created_at', $today)->pluck('emp_id')->unique();
// dd($assignedUsers);
$noClosedUsers = [];
foreach ($assignedUsers as $empId) {
    $closedCount = AssignTicket::where('emp_id', $empId)->whereIn('status',  ['Completed', 'Closed']) ->whereDate('created_at', $today)->count();

    if ($closedCount == 0) {
        $user = User::where('agentcode', $empId)->first();
        if ($user) {
            $noClosedUsers[] = [
                'emp_id' => $empId,
                'name' => $user->name ?? 'N/A',
                'mobile' => $user->mobile ?? 'N/A'
            ];
        }
    }
}
// dd($noClosedUsers);
    // Total tickets created today
    $created = Ticket::whereDate('created_at', $today)->count();
    // Ticket stats for today
    $closed = Ticket::whereIn('status', ['Completed', 'Closed'])->whereDate('created_at', $today)->count();
    // $pending = Ticket::where('status', 'Pending')->whereDate('created_at', $today)->count();
    $open = Ticket::whereIn('status', ['Open','Pending', 'Accept'])->whereDate('created_at', $today)->count();
    $total = $created;
    $data = [
        'created'   => $created,
        'closed'    => $closed,
        'open'      => $open,
        'total'     => $total
    ];
    $adminMobile = '91' . env('ADMIN_MOBILE_NO', '9999999999'); 
    $allUserData = [
        [
            'mobile' => $adminMobile,
            'data'   => $data,
            'nocloser' => $noClosedUsers
        ]
    ];
    // dd($allUserData);
    WhatsAppSend::Send('daily_support_ticket_report__ipaymnt_tech', $allUserData);
        Mail::to(env('ADMIN_MAIL'))->send(new DailyTicketReportMail($data, $allUserData));
    $this->info("Admin ticket summary sent successfully.");
}
}
