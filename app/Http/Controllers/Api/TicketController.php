<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ImageHelper;
use App\Helpers\WhatsAppSend;
use Illuminate\Http\Request;
use App\Http\Mail\TicketSubmittedMail as MailTicketSubmittedMail;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validations\TicketValidation;

class TicketController extends Controller
{
    

    public function create(Request $request)
    {


        $validations = TicketValidation::init($request, 'create');

        if ($validations['status'] == false) {
            return response()->json(['status' => false, 'message' =>  @array_values($validations['message'])[0][0]]);
        }


        $userid = base64_decode($request->user_id);

        $user = User::where('id', $userid)->where('status', 'active')->first();
   
        if (!$user) {
            abort(403);
        }
        $originalFile = '';
        $message = '';

        if ($request->hasFile('file')) {
          

            $file = request()->file('file');
            $ImageUpload = ImageHelper::imageUploadHelper('file', $file);
        
            if ($ImageUpload['status']) {
                $originalFile = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }

        $ticketId = 'TI' . $userid  . self::giveMeRandNumber(6);

        $ticketData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'service' => $request->input('category'),
            'description' => $request->input('description'),
            'priority' => $request->input('priority'),
            'plateform' => $request->input('platform'),
            'file' => $originalFile,
            'ticket_id' => $ticketId,
            'partner_id' => base64_decode($request->input('user_id')),
        ];
     
        DB::table('tickets')->insert($ticketData);


        Mail::to([$ticketData['email'], env('ADMIN_MAIL')])->send(new MailTicketSubmittedMail($ticketData));

        $check= WhatsAppSend::Send('support_ticket_created__ipayment_tech', '91'.$user->mobile);
        $check= WhatsAppSend::Send('support_ticket_created__ipayment_tech', '917091741983');
   

        return response()->json(['status' => true, 'message' => 'Ticket created successful.', 'data' => ['ticketId' => $ticketId]]);
    }

    public static function giveMeRandNumber($count)
    {
        $intMin = (10 ** $count) / 10;
        $intMax = (10 ** $count) - 1;

        $codeRandom = mt_rand($intMin, $intMax);

        return $codeRandom;
    }
}
