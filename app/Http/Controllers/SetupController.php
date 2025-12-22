<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Models\Fundbank;
use App\Models\Api;
use App\Models\Provider;
use App\Models\PortalSetting;
use App\Models\Complaintsubject;
use App\Models\Link;
use App\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SetupController extends Controller
{
    public function index($type)
    {
        switch ($type) {
            case 'userupload':
            case 'api':
                $permission = "setup_api";
                break;

            case 'bank':
                $permission = "setup_bank";
                break;

            case 'operator':
                $permission = "setup_operator";
                $data['apis'] = Api::whereIn('type', ['recharge', 'bill', 'pancard', 'cms', 'matm', 'money', 'fund'])->where('status', '1')->get(['id', 'product']);
                break;

            case 'complaintsub':
                $permission = "complaint_subject";
                break;

            case 'portalsetting':
                $data['settlementtype'] = PortalSetting::where('code', 'settlementtype')->first();
                $data['banksettlementtype'] = PortalSetting::where('code', 'banksettlementtype')->first();
                $data['otplogin'] = PortalSetting::where('code', 'otplogin')->first();
                $data['otpsendmailid'] = PortalSetting::where('code', 'otpsendmailid')->first();
                $data['otpsendmailname'] = PortalSetting::where('code', 'otpsendmailname')->first();
                $data['bcid'] = \App\Models\PortalSetting::where('code', 'bcid')->first();
                $data['cpid'] = \App\Models\PortalSetting::where('code', 'cpid')->first();
                $data['transactioncode'] = \App\Models\PortalSetting::where('code', 'transactioncode')->first();
                $data['mainlockedamount'] = \App\Models\PortalSetting::where('code', 'mainlockedamount')->first();
                $data['aepslockedamount'] = \App\Models\PortalSetting::where('code', 'aepslockedamount')->first();
                $data['settlementcharge'] = \App\Models\PortalSetting::where('code', 'settlementcharge')->first();
                $data['impschargeupto25'] = \App\Models\PortalSetting::where('code', 'impschargeupto25')->first();
                $data['impschargeabove25'] = \App\Models\PortalSetting::where('code', 'impschargeabove25')->first();
                $data['aepsslabtime'] = \App\Models\PortalSetting::where('code', 'aepsslabtime')->first();
                $permission = "portal_setting";
                break;

            case 'links':
                $permission = "setup_links";
                break;

            case 'loginslide':
                $permission = "setup_links";
                break;
            case 'mappingid':
                $permission = "mapping_manager";

                $data['parents'] = User::whereHas('role', function ($q) {
                    $q->whereIn('slug', ['distributor', 'employee']);
                })->get(['id', 'name', 'role_id', 'mobile']);


                $data['alluser'] = User::whereHas('role', function ($q) {
                    $q->where('slug', '=', 'retailer');
                })->get(['id', 'name', 'role_id', 'mobile'])->take(10);

                break;

            case 'adminprofit':
                $permission = "portal_setting";
                // $data['apis'] = Api::whereIn('type', ['recharge', 'bill', 'pancard', 'money', 'fund'])->where('status', '1')->get(['id', 'product']);
                // $data['providers'] = Provider::whereIn('type', ['mobile', 'licslab', 'dth', 'electricity', 'pancard', 'dmt', 'aeps', 'fund', 'nsdlpan', 'tax', 'lpggas', 'gasutility', 'landline', 'postpaid', 'broadband', 'water', 'loanrepay', 'lifeinsurance', 'fasttag', 'cable', 'insurance', 'schoolfees', 'muncipal', 'housing', 'idstock', 'aadharpay', 'lic', 'onlinelic', 'licbillpay', 'cms', 'product', 'giblinsurance'])->get(['id', 'name']);
                break;
            default:
                abort(404);
                break;
        }

        if (!\Myhelper::can($permission)) {
            return redirect(route('unauthorized'));
            ;
        }
        $data['type'] = $type;

        return view("setup." . $type)->with($data);
    }

    public function update(Request $post)
    {
        switch ($post->actiontype) {
            case 'api':
                $permission = "setup_api";
                break;

            case 'bank':
                $permission = "setup_bank";
                break;

            case 'operator':
                $permission = "setup_operator";
                break;

            case 'complaintsub':
                $permission = "complaint_subject";
                break;

            case 'portalsetting':
                $permission = "portal_setting";
                break;
            case 'mappingids':
                $permission = 'mapping_manager';
                break;
            case 'links':
                $permission = "setup_links";
                break;
        }

        if (isset($permission) && !\Myhelper::can($permission)) {
            return response()->json(['status' => "Permission Not Allowed"], 400);
        }

        switch ($post->actiontype) {
            case 'bank':
                $rules = array(
                    'name' => 'sometimes|required',
                    'account' => 'sometimes|required|numeric|unique:fundbanks,account' . ($post->id != "new" ? "," . $post->id : ''),
                    'ifsc' => 'sometimes|required',
                    'branch' => 'sometimes|required',
                    'charge' => 'sometimes|required'
                );

                $validator = \Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                $post['user_id'] = \Auth::id();

                $action = true;
                // check if bank already exist or not

                if (\Myhelper::hasRole('admin')) {
                    // if ($post->hasFile('fundQr')) {
                    //     $filename = 'qr' . \Auth::id() . date('ymdhis') . "_" . $post->account . "." . $post->file('fundQr')->guessExtension();
                    //     $post->file('fundQr')->move(public_path('fund_qr/'), $filename);
                    //     $post['fund_qr'] = $filename;
                    // }

                    if ($post->hasFile('fundQr')) {
                        //Upload File to the server
                        $file = request()->file('fundQr');
                        $ImageUpload = ImageHelper::imageUploadHelper('fundQr', $file);
                        if ($ImageUpload['status']) {
                            $post['fund_qr'] = $ImageUpload['data']['target_file'];
                        } else {
                            return response()->json(['status' => @$ImageUpload['message'] ?? "Task Failed, please try again"], 200);
                        }
                    }
                    $action = Fundbank::updateOrCreate(['id' => $post->id], $post->all());
                }
                if ($action) {
                    return response()->json(['status' => "success"], 200);
                } else {
                    return response()->json(['status' => "Task Failed, please try again"], 200);
                }
                break;

            case 'api':
                $rules = array(
                    'product' => 'sometimes|required',
                    'name' => 'sometimes|required',
                    'code' => 'sometimes|required|unique:apis,code' . ($post->id != "new" ? "," . $post->id : ''),
                    'type' => ['sometimes', 'required', Rule::In(['recharge', 'bill', 'money', 'pancard', 'fund'])],
                );

                $validator = \Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $action = Api::updateOrCreate(['id' => $post->id], $post->all());
                if ($action) {
                    return response()->json(['status' => "success"], 200);
                } else {
                    return response()->json(['status' => "Task Failed, please try again"], 200);
                }
                break;

            case 'operator':

                $rules = array(
                    'name' => 'sometimes|required',
                    'recharge1' => 'sometimes|required',
                    'recharge2' => 'sometimes|required',
                    'type' => ['sometimes', 'required', Rule::In(['mobile', 'dth', 'electricity', 'pancard', 'dmt', 'aeps', 'fund', 'nsdlpan'])],
                    'api_id' => 'sometimes|required|numeric',
                );

                $validator = \Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $action = Provider::updateOrCreate(['id' => $post->id], $post->all());
                if ($action) {
                    return response()->json(['status' => "success"], 200);
                } else {
                    return response()->json(['status' => "Task Failed, please try again"], 200);
                }
                break;

            case 'complaintsub':
                $rules = array(
                    'subject' => 'sometimes|required',
                );

                $validator = \Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $action = Complaintsubject::updateOrCreate(['id' => $post->id], $post->all());
                if ($action) {
                    return response()->json(['status' => "success"], 200);
                } else {
                    return response()->json(['status' => "Task Failed, please try again"], 200);
                }
                break;
            case 'mappingids':
                $rules = array(
                    'parent_id' => 'required',
                    'user_id' => 'required',
                );

                $validator = \Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                if (\Myhelper::hasNotRole(['admin', 'employee'])) {
                    return response()->json(['status' => "Permission Not Allowed"], 400);
                }


                $response = User::where('id', $post->user_id)->update(['parent_id' => $post->parent_id]);
                if ($response) {
                    return response()->json(['status' => "success"], 200);
                } else {
                    return response()->json(['status' => "Task Failed, please try again"], 200);
                }

                break;
            case 'portalsetting':
                $rules = array(
                    'value' => 'required',
                    'name' => 'required',
                    'code' => 'required',
                );

                $validator = \Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                $action = PortalSetting::updateOrCreate(['code' => $post->code], $post->all());
                ;
                if ($action) {
                    return response()->json(['status' => "success"], 200);
                } else {
                    return response()->json(['status' => "Task Failed, please try again"], 200);
                }
                break;

            case 'links':
                $rules = array(
                    'name' => 'required',
                    'value' => 'required|url',
                );

                $validator = \Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                if ($post->hasFile('quickLink')) {
                    //Upload File to the server
                    $file = request()->file('quickLink');
                    $ImageUpload = ImageHelper::imageUploadHelper('quickLinks', $file);
                    if ($ImageUpload['status']) {
                        $post['img'] = $ImageUpload['data']['target_file'];
                    } else {
                        return response()->json(['status' => $ImageUpload['message'] ?? "Task Failed, please try again"], 200);
                    }
                }
                // $filename = 'quickLink' . \Auth::id() . "_" . date('ymdhis') . "." . $post->file('quickLink')->guessExtension();
                // $post->file('quickLink')->move(public_path('quick_link/'), $filename);
                $action = Link::updateOrCreate(['id' => $post->id], $post->all());

                if ($action) {
                    return response()->json(['status' => "success"], 200);
                } else {
                    return response()->json(['status' => "Task Failed, please try again"], 200);
                }
                break;


            case 'slides':
                $rules = array(
                    'value' => 'sometimes|required',
                    'code' => 'required',
                );

                $post['company_id'] = \Auth::user()->company_id;
                $validator = \Validator::make($post->all(), $rules);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $post['name'] = "Login Slide " . date('ymdhis');
                $action = PortalSetting::updateOrCreate(['name' => $post->name], $post->all());
                if ($action) {
                    return response()->json(['status' => "success"], 200);
                } else {
                    return response()->json(['status' => "Task Failed, please try again"], 200);
                }
                break;

                return response()->json(['status' => 'success'], 200);
                break;

            default:
                # code...
                break;
        }
    }
}
