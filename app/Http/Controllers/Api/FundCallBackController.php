<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FundCallBackController extends Controller
{
   public function callback(Request $post, $api)
{
    // dd($post->all(),$api);
    try {
        $data = $post->all();
        $respTime = now();

        switch ($api) {

            case 'eb':
                if ($data['event'] === 'TRANSACTION_CREDIT') {
                    $txn = $data['data'];
             
                    $virtualAccountId = $txn['virtual_account']['id'] ?? null;
                    $userId = DB::table('user_van_accounts')->where('account_id', $virtualAccountId)->value('user_id');
// dd($userId);
                    DB::table('fund_recieved_callback')->updateOrInsert(
                        ['fund_id' => $txn['id']],
                        [
                            'event' => $data['event'],
                            'user_id' => $userId,
                            'remitter_full_name' => $txn['remitter_full_name'] ?? null,
                            'remitter_account_number' => $txn['remitter_account_number'] ?? null,
                            'remitter_ifsc' => $txn['remitter_account_ifsc'] ?? null,
                            'remitter_phone_number' => $txn['remitter_phone_number'] ?? null,
                            'utr' => $txn['unique_transaction_reference'] ?? null,
                            'payment_mode' => $txn['payment_mode'] ?? null,
                            'amount' => $txn['amount'] ?? 0,
                            'fee' => '5',
                            'tax' => '0.50',
                            'narration' => $txn['narration'] ?? null,
                            'status' => $txn['status'] ?? null,
                            'transaction_date' => $txn['transaction_date'] ?? null,
                            'virtual_account_id' => $txn['virtual_account']['id'] ?? null,
                            'label' => $txn['virtual_account']['label'] ?? null,
                            'virtual_account_number' => $txn['virtual_account']['virtual_account_number'] ?? null,
                            'virtual_ifsc_number' => $txn['virtual_account']['virtual_ifsc_number'] ?? null,
                        ]
                    );
                } 
                 return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Processed successfully',
            'time' => now()->format('Y-m-d H:i:s')
        ]);
        }

       
    } catch (Exception $e) {
        return response()->json([
            'status' => 'FAILURE',
            'message' => 'Error: ' . $e->getMessage(),
            'time' => now()->format('Y-m-d H:i:s')
        ]);
    }
}

}
