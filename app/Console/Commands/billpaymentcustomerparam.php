<?php

namespace App\Console\Commands;

use App\Helpers\CommonHelper;
use App\Http\Controllers\IYDABillPayController;
use App\Models\GlobalConfig;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class billpaymentcustomerparam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billpaymentcustomerparam:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update bill payment table for providers';

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
        // $getSettlementTiming = DB::table('portal_settings')->where('code', 'autosettlementtiming')->first(['value']);
        // if (!$getSettlementTiming) {
        //     $time = 360;
        // } else {
        //     $time = $getSettlementTiming->value;
        // }
        $callcontroller = new IYDABillPayController;
        // $messages = $callcontroller->getBillPaymentTableUpdate();
        $messages = $callcontroller->fetchProduct();

        // return $billpayment;
        $messages = "success";

        $this->info($messages);
    }
}
