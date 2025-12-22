<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\ChatTemplate;
use Illuminate\Http\Request;
use App\Models\Scheme;
use App\Models\Company;
use App\Models\Provider;
use App\Models\Commission;
use App\Models\Companydata;
use App\Models\ContactList;
use App\Models\Group;
use App\Models\Packagecommission;
use App\Models\Package;
use App\Services\ChatServices;
use App\User;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    protected $callChatTemplate;
    public function __construct()
    {
        $this->callChatTemplate = new ChatServices;
    }


    public function index()
    {
        $data['contactList'] = ContactList::where('is_visible', '1')->get();
        $data['groups'] = Group::get();
        $data['chatTemplate'] = ChatTemplate::where('status', 'active')->get();
        $data['integrateNum'] = DB::table('integrate_whats_number')->get();
        return view('chat.index')->with($data);
    }

    public function getTemplateDetails(Request $request)
    {
        $template = ChatTemplate::where('template_name', $request->template_name)->first();

        return response()->json([
            'header_var' => json_decode($template->header_var ?? '[]'),
            'body_var' => json_decode($template->body_var ?? '[]'),
            'examples' => json_decode($template->examples ?? '[]'),
        ]);
    }

    public function groupView()
    {
        return view('chat.group');
    }

    public function createTemplateView()
    {
        $data['integrateNum'] = DB::table('integrate_whats_number')->get();
        return view('chat.createtemplate')->with($data);
    }

    public function createWhatsappTemplate(Request $request)
    {

        $validated = $request->validate([
            'template_name' => 'required|string|unique:chat_template,template_name',
            'integrated_number' => 'required',
            'language' => 'required',
            'category' => 'required',
            'body_text' => 'required',
        ]);

        $buttons = [];
        $url_buttons = [];

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'quick_reply_') === 0 && !empty($value)) {
                $buttons[] = $value;
            }

            // URL Buttons
            if (strpos($key, 'url_button_text_') === 0) {
                $suffix = str_replace('url_button_text_', '', $key);
                $url_text = $value;
                $url_value = $request->input("url_button_url_" . $suffix);
                if ($url_text && $url_value) {
                    $url_buttons[] = [
                        'text' => $url_text,
                        'url' => $url_value
                    ];
                }
            }
        }

        $bodyVars = [];
        foreach ($request->all() as $key => $value) {
            if (\Str::startsWith($key, 'variable_var_')) {
                $bodyVars[] = $value;
            }
        }

        $up = [
            'template_name' => @$request->template_name,
            'integrated_number' => @$request->integrated_number,
            'language' => @$request->language,
            'category' => @$request->category,
            'template_type' => @$request->templateType,
            'header_text' => @$request->header_text,
            'body_text' => @$request->body_text,
            'footer_text' => @$request->footer_text,
            'header_type' => "HEADER",
            'button_url' => "true",
            'is_approved' => "Yes",
            'status' => "active",
            'user_id' => @$request->user_id,
            'buttons' => json_encode($buttons),
            'examples' => json_encode(array_column($url_buttons, 'url')),
            'url_button_text' => json_encode(array_column($url_buttons, 'text')),
            'call_btn_txt' => @$request->call_button_text ?? "",
            'call_btn_num' => @$request->call_phone_number ?? "",
            'header_var' => json_encode([$request->headerVariableValue]) ?? "",
            'body_var' => !empty($bodyVars) ? json_encode($bodyVars) : json_encode([])
        ];

        $result = $this->callChatTemplate->createTemplateFunc($request);

        $resp = json_decode($result['response'], true);

        if ($resp['status'] == 'success') {
            $up['template_id'] = $resp['data']['template_id'];
            $inst = ChatTemplate::create($up);
            if ($inst) {
                return response()->json(['status' => 'success', 'data' => ['template_id' => $resp['data']['template_id']], 'message' => $resp['data']['message']]);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Template not added']);
            }
        }
        return response()->json(['status' => 'failed', 'message' => $resp['errors'] ?? 'Template not created']);
    }

    public function getMessages(Request $request)
    {

        $messages = DB::table('send_messages')
            ->where('to_mobile', $request->mobile)
            ->orderBy('created_at', 'asc')
            ->get();

        $messages = $messages->map(function ($msg) {
            $template = ChatTemplate::where('template_name', $msg->message)->where('is_send', 'Yes')->first();

            return [
                'headerText' => $template->header_text ?? null,
                'examples' => $template->examples ?? null,
                'urlButtonText' => $template->url_button_text ?? null,
                'bodyText' => $template->body_text ?? null,
                'footerText' => $template->footer_text ?? null,
                'buttonJson' => $template->buttons ?? null,
                'status' => $msg->status,
                'replyText' => $msg->text,
                'isReply' => $msg->is_reply,
                'customerName' => $msg->customer_name,
                'contentJson' => $msg->content_json,
                'direction' => $msg->direction,
                'created_at' => $msg->created_at,
                'header_var' => $msg->header_var ?? $template->header_var,
                'body_var' => $msg->body_var ?? $template->body_var
            ];
        });
        return response()->json(['messages' => $messages]);
    }

    public function sendWhatsappTemplate(Request $request)
    {
        $validated = $request->validate([
            'template_name' => 'required',
            'language' => 'required',
            'fromMob' => 'required|numeric',
            'toMob' => 'required|numeric',
        ]);

        $result = $this->callChatTemplate->sendTemplateFunc($request);

        $resp = json_decode($result['response'], true);

        if ($resp['status'] == 'success') {

            $up['is_send'] = 'Yes';
            $up['to_number'] = $request->toMob;

            $inst = ChatTemplate::where('template_name', $request->template_name)->update($up);

            $headerVars = [];
            $bodyVars = [];

            foreach ($request->all() as $key => $value) {
                if (\Str::startsWith($key, 'header_var_')) {
                    $headerVars[] = $value;
                }

                if (\Str::startsWith($key, 'body_var_')) {
                    $bodyVars[] = $value;
                }
            }

            DB::table('send_messages')->insert([
                'user_id' => $request->user_id,
                'message' => $request->template_name,
                'msg_req_id' => $resp['request_id'],
                'to_mobile' => $request->toMob,
                'from_mobile' => $request->fromMob,
                'is_send' => 'Yes',
                'status' => 'submitted',
                'direction' => 'outbound',
                'response' => null,
                'msg_resp_id' => null,
                'header_var' => json_encode($headerVars),
                'body_var' => json_encode($bodyVars)
            ]);

            if ($inst) {
                return response()->json(['status' => 'success', 'message' => $resp['data']]);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Send Template Failed']);
            }
        }
        return response()->json(['status' => 'failed', 'message' => $resp['errors'] ?? 'Template not send']);
    }

    public function addContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|unique:contact_list,mobile',
            'about' => 'nullable|string',
            'avatar' => 'nullable|image',
            'group_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $validated['status'] = "active";
        $validated['is_visible'] = "1";
        if ($request->about) {
            $validated['about'] = $request->about;
        } else {
            $validated['about'] = "Hello, I'm using whatsapp";
        }

        $inst = ContactList::create($validated);
        if ($inst) {
            return response()->json(['status' => 'success', 'message' => 'Contact added successfully']);
        }
        return response()->json(['status' => 'failed', 'message' => 'Contact not added']);
    }
    public function addGroup(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|unique:group_list,group_name',
            'user_id' => 'required'
        ]);

        if ($request->groupId == '') {
            $inst = Group::create([
                'user_id' => auth()->id(),
                'group_name' => $request->group_name
            ]);
            if ($inst) {
                return response()->json(['status' => 'success', 'message' => 'Group added successfully']);
            }
            return response()->json(['status' => 'failed', 'message' => 'Group not added']);
        } else {
            $inst = Group::where('id', $request->groupId)->update([
                'group_name' => $request->group_name
            ]);
            if ($inst) {
                return response()->json(['status' => 'success', 'message' => 'Group updated successfully']);
            }
            return response()->json(['status' => 'failed', 'message' => 'Group not update']);
        }

        return response()->json(['status' => 'failed', 'message' => 'Group not added']);
    }

    public function deleteContact(Request $request)
    {
        $contact = ContactList::where('mobile', $request->id)->first();
        if ($contact) {
            $contact->update(['is_visible' => 0]);
            return response()->json(['status' => 'success', 'message' => 'Contact deleted sucessfully']);
        }
        return response()->json(['status' => 'error', 'message' => 'Contact not found']);
    }
}
