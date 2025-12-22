<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CallbackController extends Controller
{
    public function callback(Request $post, $api)
    {
        try {
            switch ($api) {
                case 'whatsapp':

                    $data = $post->all();

                    $requestId = isset($data['request_id']) ? $data['request_id'] : '';

                    $resType = isset($data['type']) ? $data['type'] : 'NA';
                    $responseCode = isset($data['responseCode']) ? $data['responseCode'] : '';
                    $respId = $data['respId'] ?? '';
                    $muid = $data['message_uuid'] ?? null;
                    $respTime = now();


                    $inst = DB::table('apilogs')->insert([
                        'modal' => 'fidypay',
                        'method' => 'Callback',
                        'response' => json_encode($data),
                        'txnid' => $requestId,
                        'resp_type' => $resType,
                        'resp_code' => isset($data['responseCode']) ? $data['responseCode'] : 'NA',
                        'resp_message' => isset($data['description']) ? $data['description'] : 'NA',
                    ]);

                    if ($inst && $requestId) {
                        $updateData = [
                            'status' => $data['status'] ?? null,
                            'requested_at' => isset($data['requested_at']) ? Carbon::createFromTimestamp($data['requested_at']) : null,
                            'submitted_at' => isset($data['submitted_at']) ? Carbon::createFromTimestamp($data['submitted_at']) : null,
                            'sent_at' => isset($data['sent_at']) ? Carbon::createFromTimestamp($data['sent_at']) : null,
                            'delivered_at' => isset($data['delivered_at']) ? Carbon::createFromTimestamp($data['delivered_at']) : null,
                            'read_at' => isset($data['read_at']) ? Carbon::createFromTimestamp($data['read_at']) : null,
                            'failure_reason' => $data['failure_reason'] ?? null,
                            'updated_at' => $respTime,
                            'msg_id' => $muid
                        ];

                        $updateData = array_filter($updateData, fn($v) => !is_null($v));

                        DB::table('send_messages')
                            ->where('msg_req_id', $requestId)
                            ->update($updateData);


                        if (!empty($data['replied_message_id'])) {
                            DB::table('send_messages')->insert([
                                'msg_id' => $muid ?? null,
                                'from_mobile' => $data['sender'] ?? null,
                                'to_mobile' => $data['integrated_number'] ?? null,
                                'replied_message_id' => $data['replied_message_id'] ?? null,
                                'status' => 'received',
                                'direction' => 'inbound',
                                'customer_name' => $data['customer_name'] ?? ($data['contacts'][0]['profile']['name'] ?? null),
                                'content_json' => json_encode($data['messages'][0]['text'] ?? $data['text'] ?? []),
                                'received_at' => isset($data['received_at']) ? $data['received_at'] : now(),
                                'is_reply' => 'true',
                                'message' => $data['template_name'] ?? null,
                                'text' =>  json_encode($data['messages'][0]['text'] ?? $data['text'] ?? []),
                            ]);
                        }
                    }
                    break;

                default:
                    Storage::put('default' . time() . '.txt', print_r($post->all(), true));

                    $res['status'] = 'FAILURE';
                    $res['message'] = 'Unexpected response received';
                    $res['time'] = date('Y-m-d H:i:s');

                    return response()->json($res);
                    break;
            }
        } catch (Exception $e) {
            $res['status'] = 'FAILURE';
            $res['message'] = 'Error: ' . $e->getMessage();
            $res['time'] = date('Y-m-d H:i:s');

            return response()->json($res);
        }
        $res['status'] = $res['status'] ?? 'FAILURE';
        $res['message'] = $res['message'] ?? 'Error';
        $res['time'] = date('Y-m-d H:i:s');

        return response()->json($res);
    }
}
