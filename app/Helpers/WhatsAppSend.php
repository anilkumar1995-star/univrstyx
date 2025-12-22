<?php

namespace App\Helpers;


use App\Models\Api;
use App\Models\Apilog;
use App\Models\Ticket;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Auth;

class WhatsAppSend
{
          public static function CreateTicket($type , $userList=[])
    {   
        $header = ['Content-Type: application/json', 'authkey: 397015ALb2xhc3mFh669a69ecP1'];
        $url = "https://api.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/bulk/";
        foreach ($userList as $user) {
           $mobile = $user['mobile'];
             $mobile = '91' . $mobile;
         $ticket_id = $user['ticket_id'];
         $subject = $user['subject'];

        $message=self::setVariableCreate($type , $mobile, 'https://crm.ipayments.in/',$ticket_id,$subject);

         self::curlCall($url, 'POST', $message, $header);
    }
    return true;
    }
    public static function Send($type, $userList = [])
    {
        //  dd($type, $userList, );
        $header = [
            'Content-Type: application/json',
            'authkey: 397015ALb2xhc3mFh669a69ecP1'
        ];
        $url = "https://api.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/bulk/";

        foreach ($userList as $user) {
            if (!isset($user['mobile'])) {
                continue;
            }
            $mobile = $user['mobile'];
            $data = $user['data'] ?? [];
            $nocloser = $user['nocloser'] ?? [];

            if (empty($data) && empty($nocloser)) {
                continue;
            }
            $message = self::setVariable($type, $mobile, 'https://crm.ipayments.in/', $data, $nocloser);
            self::curlCall($url, 'POST', $message, $header);
        }
        return true;
    }
    public static function SendWhatsapp($type, $ticketList = [])
    {
        $header = [
            'Content-Type: application/json',
            'authkey: 397015ALb2xhc3mFh669a69ecP1'
        ];

        $url = "https://api.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/bulk/";
        $data = $ticketList;
        foreach ($ticketList as $ticket) {
            if ($ticket instanceof Ticket) {
                $user = User::find($ticket->user_id);
                $mobile = $user->mobile;
                 $mobile = '91' . $mobile;
                 $name = $user->name;

                if ($mobile) {
                    $message = self::setVariables($type, $mobile, 'https://crm.ipayments.in/', $ticket, $name);
                   self::curlCall($url, 'POST', $message, $header);
                }
            }
        }
        return true;
    }


    public static function setVariable($type, $mobile, $url = '', $data = [], $nocloser = [])
    {
        // dd($type,$mobile,$data);
        if (!is_array($nocloser)) {
            try {
                $nocloser = json_decode($nocloser, true);
                if (!is_array($nocloser)) {
                    $nocloser = [];
                }
            } catch (\Exception $e) {
                $nocloser = [];
            }
        }
        $nocloserNames = array_map(function ($u) {
            return $u['name'] ?? 'N/A';
        }, $nocloser);
        $nocloserNamesStr = implode(', ', $nocloserNames);
        // dd($nocloserNamesStr);
        $template = "";
        switch ($type) {
            case 'daily_support_ticket_report__ipaymnt_tech':
                $template = '{
                "integrated_number": "919147173395",
                "content_type": "template",
                "payload": {
                    "messaging_product": "whatsapp",
                    "type": "template",
                    "template": {
                        "name": "daily_support_ticket_report__ipaymnt_tech",
                        "language": {
                            "code": "en",
                            "policy": "deterministic"
                        },
                        "namespace": "68dc16bb_55a9_4ef6_8902_fda23604ecf8",
                        "to_and_components": [
                            {
                                "to": ["' . $mobile . '"],
                                "components": {
                                    "body_1": {
                                        "type": "text",
                                        "value": "' . ($data['created'] ?? 0) . '"
                                    },
                                    "body_2": {
                                        "type": "text",
                                        "value": "' . ($data['closed'] ?? 0) . '"
                                    },
                                    "body_3": {
                                        "type": "text",
                                        "value": "' . ($data['open'] ?? 0) . '"
                                    },
                                    "body_4": {
                                        "type": "text",
                                        "value": "' . ($data['open'] ?? 0) . '"
                                    },
                                    "body_5": {
                                        "type": "text",
                                        "value": "' . ($data['created'] ?? 0) . '"
                                    },
                                    "body_6": {
                                        "type": "text",
                                        "value": "' .  $nocloserNamesStr  . '"
                                    },
                                    "button_1": {
                                        "subtype": "url",
                                        "type": "text",
                                        "value": "' . $url . '"
                                    }
                                }
                            }
                        ]
                    }
                }
            }';

                break;
            case 'support_ticket_resolved_and_ticket_close':
                $todayCreateTicket = Ticket::whereDate('created_at', date('Y-m-d'))->count();
                $todayResoledTicket = Ticket::where('status', 'closed')->whereDate('created_at', date('Y-m-d'))->count();
                $template = '{
                                "integrated_number": "919147173395",
                                "content_type": "template",
                                "payload": {
                                    "messaging_product": "whatsapp",
                                    "type": "template",
                                    "template": {
                                        "name": "support_ticket_resolved_and_ticket_close",
                                        "language": {
                                            "code": "en",
                                            "policy": "deterministic"
                                        },
                                        "namespace": "68dc16bb_55a9_4ef6_8902_fda23604ecf8",
                                        "to_and_components": [
                                            {
                                                "to": [
                                                    "' . $mobile . '"
                                                ],
                                                "components": {
                                                    "body_1": {
                                                        "type": "text",
                                                        "value": "' . $todayCreateTicket . '"
                                                    },
                                                    "body_2": {
                                                        "type": "text",
                                                        "value": "' . $todayResoledTicket . '"
                                                    },
                                                    "button_1": {
                                                        "subtype": "url",
                                                        "type": "text",
                                                        "value": "' . $url . '"
                                                    }
                                                }
                                            }
                                        ]
                                    }
                                }
                            }';

                break;
        }
        return  $template;
    }

     public static function setVariables($type, $mobile, $url = '', $data = [], $name)
    {
        // dd($type,$mobile,$data,$name);
    
        $template = "";
        switch ($type) {

            case 'support_ticket_assigen':
                // dd($mobile,$type,$data);
                $template = '{
                            "integrated_number": "919147173395",
                            "content_type": "template",
                            "payload": {
                                "messaging_product": "whatsapp",
                                "type": "template",
                                "template": {
                                    "name": "support_ticket_assigen",
                                    "language": {
                                        "code": "en",
                                        "policy": "deterministic"
                                    },
                                    "namespace": "68dc16bb_55a9_4ef6_8902_fda23604ecf8",
                                    "to_and_components": [
                                        {
                                            "to": [
                                                "' .$mobile. '"
                                            ],
                                            "components": {
                                                "header_1": {
                                                    "type": "text",
                                                    "value": "'.$name.'"
                                                },
                                                "body_1": {
                                                    "type": "text",
                                                    "value": "'.$name.'"
                                                },
                                                "body_2": {
                                                    "type": "text",
                                                    "value": "'.($data['ticket_id']).'"
                                                },
                                                "body_3": {
                                                    "type": "text",
                                                    "value": "'.($data['description']).'"
                                                },
                                                "body_4": {
                                                    "type": "text",
                                                    "value": "'.($data['name']).'"
                                                },
                                                "body_5": {
                                                    "type": "text",
                                                    "value": "'.($data['priority']).'"
                                                },
                                                "body_6": {
                                                    "type": "text",
                                                    "value": "https://www.ipayments.in"
                                                },
                                                "button_1": {
                                                    "subtype": "url",
                                                    "type": "text",
                                                    "value": "https://www.ipayments.in"
                                                }
                                            }
                                        }
                                    ]
                                }
                            }
                        }';
                break;
        }
        // dd($template);
        return  $template;
    }
      public static function setVariableCreate($type, $mobile, $url='',$ticket_id,$subject)
    {
        // dd($type,$mobile,$url,$ticket_id,$subject);
       
        $template = "";
        switch ($type) {

             case 'support_ticket_created__ipayment_tech':
                $ticket = Ticket::orderBy('id', 'desc')->first();
                $template = '{
                                    "integrated_number": "919147173395",
                                    "content_type": "template",
                                    "payload": {
                                        "messaging_product": "whatsapp",
                                        "type": "template",
                                        "template": {
                                            "name": "support_ticket_created__ipayment_tech",
                                            "language": {
                                                "code": "en",
                                                "policy": "deterministic"
                                            },
                                            "namespace": "68dc16bb_55a9_4ef6_8902_fda23604ecf8",
                                            "to_and_components": [
                                                {
                                                    "to": [
                                                        "' . $mobile . '"
                                                    ],
                                                    "components": {
                                                        "body_1": {
                                                            "type": "text",
                                                            "value": "' . $subject . '"
                                                        },
                                                        "body_2": {
                                                            "type": "text",
                                                            "value": "' . $ticket_id . '"
                                                        },
                                                        "button_1": {
                                                            "subtype": "url",
                                                            "type": "text",
                                                            "value": "' . $url . '"
                                                        }
                                                    }
                                                }
                                            ]
                                        }
                                    }
                                }';
                break;
        }
        return  $template;
    }
    public static function curlCall($url, $method, $parameters, $header)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 200);
        curl_setopt($curl, CURLOPT_TIMEOUT, 300);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if ($parameters != "") {
            curl_setopt($curl, CURLOPT_POSTFIELDS, @$parameters);
        }
        if (sizeof($header) > 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $resp['status'] = false;
        $resp['message'] = "error found";
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $resp['message'] = $error_msg;
        }
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $resp['status'] = true;
        $resp['data'] = $response;
        return $resp;
    }
}
