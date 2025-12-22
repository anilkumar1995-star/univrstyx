<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\WhatsAppSend;
use App\Mail\TicketSubmittedMail;
use App\Mail\AssignedTicket;
use App\Mail\ReplyTicketMail;
use App\Models\AssignTicket;
use App\Helpers\DataTableHelpers;
use App\Http\Mail\AssignedTicketMail;
use App\Http\Mail\ReplyTicketMail as MailReplyTicketMail;
use App\Http\Mail\TicketSubmittedMail as MailTicketSubmittedMail;
use App\Models\Department;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\ReplyTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use function Laravel\Prompts\alert;

class TicketController extends Controller
{

    public function tickets(Request $request)
    {
        $data['type'] = "Reports";
        $data['statements'] = Ticket::orderBy('id')->get();
        $data['department'] = Department::orderBy('id')->get();
        $query = Ticket::orderBy('id');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        return view('tools.tickets')->with($data);
    }
//     public function getStatusByDepartment($id)
// {
//     $statuses = Ticket::where('department_name', $id)
//                     ->select('status')
//                     ->distinct()
//                     ->pluck('status')
//                     ->filter() // remove nulls
//                     ->unique()
//                     ->values();

//     $statusOptions = [];
//     foreach ($statuses as $status) {
//         $statusOptions[$status] = ucfirst($status);
//     }

//     return response()->json($statusOptions);
// }  
public function ticketDetails(Request $request)
{
     if (!\Auth::check()) {
    return redirect('unauthorized');
}
    $ticket_id = $request->query('id');
    $ticket = Ticket::where('ticket_id',$ticket_id)->first();
    $partnerId = AssignTicket::where('ticket_id',$ticket_id)->select('partner_id')->first();
   $rep = ReplyTicket::with('user')->where('ticket_id', $ticket_id)->orderBy('created_at','desc')->get();
    $count = ReplyTicket::where('ticket_id', $ticket_id)->count();
    return view('tools.ticket_details', compact('ticket','rep','count','partnerId'));
}
    public function fetchTickets($status)
{
    // dd($status);
    $query = Ticket::orderBy('id');

    if ($status !== '0') {
        $query->where('status', $status);
    }

    return response()->json(['data' => $query->get()]);
}

public function fetchData(Request $request)
{
    alert($request);
    $query = Ticket::query();

    if ($request->filled('department_id') && $request->department_id != '0') {
        $query->where('department_name', $request->department_id);
    }

    if ($request->filled('status') && $request->status != '0') {
        $query->where('status', $request->status);
    }

return DataTableHelpers::build($request, $query, ['ticket_id', 'subject', 'status', 'department_id']);
}
    public function getEmployees($id)
    {
        $employees = User::where('department_id', $id)->get();

        return response()->json($employees);
    }

    public function assignTicket()
    {
        return view('tools.assignticket');
    }
    public function replyTicket()
    {
        return view('tools.replyticket');
    }

    public function getStatus($id)
    {

        $replies = ReplyTicket::where('ticket_id', $id)->orderBy('desc', 'asc')->get(['status', 'ticket_id', 'created_at', 'desc', 'file']);
        $rep = Ticket::where('ticket_id', $id)->first(['priority']);

        if ($replies->isEmpty()) {
            return response()->json(['message' => 'No replies found'], 404);
        }

        return response()->json([
            'statuses' => $replies,
            'priority' => $rep ? $rep->priority : null
        ]);
    }





    public function show(Request $request)
    {

        $ticketId = $request->query('ticket_id');

        $ticket = null;

        if ($ticketId) {
            $ticket = Ticket::where('ticket_id', $ticketId)->first();
            $repticket = ReplyTicket::where('ticket_id', $ticketId)->orderBy('id', 'desc')->first();

            //$rep = Ticket::where('ticket_id', $repticket->ticket_id)->first();

        }

        return view('ticket.index', compact('ticket', 'repticket'));
    }
    public function viewtickets(Request $request)
    {
        $uid = base64_decode($request->uid);

        $agcode = ($request->agentCode);

        $user = User::where('agentcode', $agcode)->where('id', $uid)->where('status', 'active')->first();

        if ($user) {
            $ticket = Ticket::where('partner_id', $uid)->orderBy('id', 'desc')->get();
            return view('ticket.status', compact('ticket'));
        } else {
            abort(403);
        }
    }

    public function createticket(Request $request)
    {
        $userid = base64_decode($request->uid);

        $user = User::where('id', $userid)->where('status', 'active')->first();
        if ($user) {
            return view('CreateTicket');
        } else {
            abort(403);
        }
    }

    public static function giveMeRandNumber($count)
    {
        $intMin = (10 ** $count) / 10;
        $intMax = (10 ** $count) - 1;

        $codeRandom = mt_rand($intMin, $intMax);

        return $codeRandom;
    }


    public function assignticketstore(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|string|max:255',
            'ticket_id' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);
        $assignToUser = User::where('agentcode', $request->emp_id)->where('status', 'active')->first();
        $assignByUser = User::where('id', $request->user_id)->where('status', 'active')->first();
        $roleBy = Role::where('id', $assignByUser->role_id)->first();
        $roleTo = Role::where('id', $assignToUser->role_id)->first();

        if (!$assignByUser) {
            abort(403);
        }

        $originalFile = '';
        $message = '';

        if ($request->hasFile('file')) {
            /*$file = $request->file('file');
            $originalFile = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('img');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $originalFile); */

            $file = request()->file('file');
            $ImageUpload = ImageHelper::imageUploadHelper('file', $file);

            if ($ImageUpload['status']) {
                $originalFile = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }
        $assignTicketData = [
            'user_id' => $assignToUser->id,
            'partner_id' => $request->partner_id ?? 0,
            'emp_id' => $request->emp_id,
            'ticket_id' => $request->ticket_id,
            'file' => $originalFile,
            'assign_by' => $assignByUser->name . "(" . $roleBy->name .  ")",
            'assign_to' => $assignToUser->name . "(" . $roleTo->name .  ")",
            'department_name' => $request->department_name,
            'status' => 'Open'
        ];
        $ems = User::where('agentcode', $request->emp_id)->first();
         $inst = AssignTicket::updateOrCreate(
        ['ticket_id' => $request->ticket_id],
        $assignTicketData
    );
        $up = [
            'status' => 'Open',
            'user_id' => $assignToUser->id,
            'assign_by' => $assignByUser->name . "(" . $roleBy->name .  ")",
            'assign_to' => $assignToUser->name . "(" . $roleTo->name .  ")",
            'department_name' => $request->department_name,
        ];

        Ticket::where('ticket_id', $request->ticket_id)->update($up);
        $asd = Ticket::where('ticket_id', $request->ticket_id)->first();
        $asds[] = Ticket::where('ticket_id', $request->ticket_id)->first();
        // dd($asd);
        if ($inst) {
           $m= Mail::to([$ems->email, env('ADMIN_MAIL')])->send(new AssignedTicketMail($asd));
          $w=  WhatsAppSend::SendWhatsapp('support_ticket_assigen', $asds);
        }

        return response()->json(['status' => true, 'message' => 'Ticket assign and Email sent.']);
    }

    public function replyticketstore(Request $request)
    {

        $request->validate([
            'emp_id' => 'required|string|max:255',
            'ticket_id' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,webp|max:9048',
        ]);

        $user = User::where('agentcode', $request->emp_id)->where('status', 'active')->first();

        if (!$user) {
           return response()->json(['status' => false, 'message' => 'You are not Authorized']);
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
        $replyTicketData = [
            'user_id' => $user->id,
            'partner_id' => $request->partner_id,
            'file' => $originalFile,
            'desc' => $request->description,
            'status' => $request->work_status,
            'emp_id' => $request->emp_id,
            'ticket_id' => $request->ticket_id
        ];
  
        $inst = ReplyTicket::insert($replyTicketData);

        Ticket::where('ticket_id', $request->ticket_id)->update([
            'status' => $request->work_status
        ]);
        AssignTicket::where('ticket_id', $request->ticket_id)->update([
            'user_id' => $user->id,
            'status' => $request->work_status
        ]);
        $asd = Ticket::where('ticket_id', $request->ticket_id)->first();

        if ($inst) {
            Mail::to([$asd->email, env('ADMIN_MAIL')])->send(new MailReplyTicketMail($asd));
        }

        return response()->json(['status' => true, 'message' => 'Ticket reply and Email sent.']);
    }

    public function ticketstore(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'subject' => 'required|string|max:255',
            'plateform' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $userid = base64_decode($request->user_id);
        $user = User::where('id', $userid)->where('status', 'active')->first();
        if (!$user) {
            abort(403);
        }
        $originalFile = '';
        $message = '';

        if ($request->hasFile('file')) {
            /*$file = $request->file('file');
            $originalFile = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('img');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $originalFile); */

            $file = request()->file('file');
            $ImageUpload = ImageHelper::imageUploadHelper('file', $file);

            if ($ImageUpload['status']) {
                $originalFile = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }

        $ticketId = 'TI' . $userid . '_' . self::giveMeRandNumber(6);

        $ticketData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'plateform' => $request->input('plateform'),
            'description' => $request->input('description'),
            'priority' => $request->input('priority'),
            'file' => $originalFile,
            'user_id' => '',
            'ticket_id' => $ticketId,
            'partner_id' => base64_decode($request->input('user_id')),
        ];

        DB::table('tickets')->insert($ticketData);


        Mail::to([$ticketData['email'], env('ADMIN_MAIL')])->send(new MailTicketSubmittedMail($ticketData));
        $allUserData = [
            [
                'mobile' => env('ADMIN_MOBILE_NO'),
                'ticket_id' => $ticketId,
                'subject' => $request->input('subject'),
            ]
        ];
        $check = WhatsAppSend::CreateTicket('support_ticket_created__ipayment_tech', $allUserData);
        // $check= WhatsAppSend::Send('support_ticket_created__ipayment_tech', '917091741983');


        return response()->json(['status' => true, 'message' => 'Ticket created and email sent.']);
    }
}
