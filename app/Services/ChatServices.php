<?php

namespace App\Services;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\Permission;

class ChatServices
{
    private $authKey, $authSecret, $workingKey, $endPoint, $baseUrl = "", $header = [], $fullUrl, $method, $reqBody;

    public function __construct()
    {

        $this->authKey = env('SMS_AUTH_KEY');
        $this->baseUrl = env('SMS_BASE_URL');
        $this->header = [
            "Content-Type: application/json",
            "Authkey: $this->authKey"
        ];
    }

    public function setFullUrl($method)
    {
        if ($method == 'createTemplate')
            return $this->baseUrl . 'v5/whatsapp/client-panel-template/';
        else if ($method == 'sendTemplate')
            return $this->baseUrl . 'v5/whatsapp/whatsapp-outbound-message/bulk/';

        return "";
    }

    public function sendCurlReq()
    {
        $result = Permission::curl(@$this->fullUrl, @$this->method, $this->reqBody, $this->header, "yes", @$this->endPoint, @$this->reqBody->mobile);
        return $result;
    }

    //-------------- API Integration Chat Service --------------------------------

    public function createTemplateFunc($request)
    {
        $this->endPoint = "createTemplate";
        $this->method = "POST";
        $buttons = [];

        // Handle all request parameters
        $params = $request->all();

        // QUICK_REPLY Buttons
        foreach ($params as $key => $value) {
            if (\Str::startsWith($key, 'quick_reply_') && !empty($value)) {
                $buttons[] = [
                    "type" => "QUICK_REPLY",
                    "text" => $value
                ];
            }
        }

        // URL Buttons
        foreach ($params as $key => $value) {
            if (\Str::startsWith($key, 'url_button_text_')) {
                $index = str_replace('url_button_text_', '', $key);
                $text = $value;
                $urlKey = 'url_button_url_' . $index;
                if (!empty($text) && isset($params[$urlKey]) && !empty($params[$urlKey])) {
                    $buttons[] = [
                        "type" => "URL",
                        "text" => $text,
                        "url" => $params[$urlKey],
                        "example" => [$params[$urlKey]]
                    ];
                }
            }
        }

        // HEADER Variables
        $headerText = $params['header_text'] ?? '';
        $headerExample = null;

        if (\Str::contains($headerText, '{{1}}') && !empty($params['headerVariableValue'])) {
            $headerExample = [
                "header_text" => [
                    $params['headerVariableValue']
                ]
            ];
        }

        // BODY Variables (detect and collect in order)
        $bodyText = $params['body_text'] ?? '';
        preg_match_all('/{{(\d+)}}/', $bodyText, $matches);
        $bodyVariableIndexes = $matches[1]; // [1,2,3,...]
        $bodyExampleArray = [];

        foreach ($bodyVariableIndexes as $index) {
            $key = 'variable_var_' . $index;
            $bodyExampleArray[] = $params[$key] ?? "Sample value of variable {$index}";
        }

        // COMPONENTS array
        $components = [];

        // HEADER component
        if (!empty($headerText)) {
            $components[] = [
                "type" => "HEADER",
                "format" => strtoupper($params['headerType']),
                "text" => $headerText,
                "example" => $headerExample
            ];
        }

        // BODY component
        $components[] = [
            "type" => "BODY",
            "text" => $bodyText,
            "example" => [
                "body_text" => [$bodyExampleArray]
            ]
        ];

        // FOOTER component
        if (!empty($params['footer_text'])) {
            $components[] = [
                "type" => "FOOTER",
                "text" => $params['footer_text']
            ];
        }

        // BUTTON component
        if (!empty($buttons)) {
            $components[] = [
                "type" => "BUTTONS",
                "buttons" => $buttons
            ];
        }

        // Final payload
        $this->reqBody = json_encode([
            "integrated_number" => "91" . $params['integrated_number'],
            "template_name" => $params['template_name'],
            "language" => $params['language'],
            "category" => $params['category'],
            "button_url" => "true",
            "components" => $components
        ]);

        // dd($request);
        // $components = [];

        // if ($request->headerType === 'text') {
        //     $components[] = [
        //         "type" => "HEADER",
        //         "format" => "TEXT",
        //         "text" => $request->header_text,
        //         "example" => [
        //             "header_text" => ["Sample content for Header"]
        //         ]
        //     ];
        // }

        // $this->reqBody = json_encode([
        //     "integrated_number" => "91" . $request->integrated_number,
        //     "template_name" => $request->template_name,
        //     "language" => $request->language,
        //     "category" => $request->category,
        //     "button_url" => "true",
        //     "components" => $components
        // ]);
        // $this->reqBody = json_encode([
        //     "integrated_number" => 91 . @$request->integrated_number,
        //     "template_name" => @$request->template_name,
        //     "language" => @$request->language ?? "en_US",
        //     "category" => @$request->category,
        //     "button_url" => "true",
        //     "components" => [
        //         [
        //             "type" => "HEADER",
        //             "format" => "TEXT",
        //             "text" => @$request->header_text ?? "",
        //             "example" => [
        //                 "header_text" => [
        //                     @$request->header_text ?? ""
        //                 ]
        //             ]
        //         ],
        //         [
        //             "type" => "BODY",
        //             "text" => @$request->body_text ?? "",
        //             "example" => [
        //                 "body_text" => [
        //                 [
        //                     "Sample value of third variable"
        //                 ]
        //                 ]
        //             ]
        //         ],
        //         [
        //             "type" => "FOOTER",
        //             "text" => @$request->footer_text ?? ""
        //         ],
        //         [
        //             "type" => "BUTTONS",
        //             "buttons" => [
        //                 [
        //                     "type" => "QUICK_REPLY",
        //                     "text" => @$request->quick_reply_1
        //                 ],
        //                 [
        //                     "type" => "QUICK_REPLY",
        //                     "text" => @$request->quick_reply_2
        //                 ],
        //                 [
        //                     "type" => "URL",
        //                     "text" => @$request->url_button_text,
        //                     "url" => @$request->url_button_url,
        //                     "example" => [
        //                         "https://google.com"
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     ]
        // ]);

        $this->fullUrl = $this->setFullUrl('createTemplate');

        $sendRequest = $this->sendCurlReq();


        // $sendRequest = $this->staticResponse();
        return $sendRequest;
    }

    public function sendTemplateFunc($request)
    {
        $this->endPoint = "sendTemplate";
        $this->method = "POST";

        $components = [];

        // 3. Example URL buttons
        // $buttonIndex = 1;
        // foreach ($request->all() as $key => $value) {
        //     if (\Str::startsWith($key, 'example_url_')) {
        //         $components["button_$buttonIndex"] = [
        //             "subtype" => "url",
        //             "type" => "text",
        //             "value" => $value
        //         ];
        //         $buttonIndex++;
        //     }
        // }

        // 1. Header variables
        foreach ($request->all() as $key => $value) {
            if (\Str::startsWith($key, 'header_var_')) {
                $index = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                $components["header_$index"] = [
                    "type" => "text",
                    "value" => $value
                ];
            }
        }

        // 2. Body variables
        foreach ($request->all() as $key => $value) {
            if (\Str::startsWith($key, 'body_var_')) {
                $index = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                $components["body_$index"] = [
                    "type" => "text",
                    "value" => $value
                ];
            }
        }


        // $this->reqBody = json_encode([
        //     "integrated_number" => 91 . @$request->fromMob,
        //     "content_type" => "template",
        //     "payload" => [
        //         "messaging_product" => "whatsapp",
        //         "type" => "template",
        //         "template" => [
        //             "name" => @$request->template_name,
        //             "language" => [
        //                 "code" => @$request->language,
        //                 "policy" => "deterministic"
        //             ],
        //             "namespace" => "68dc16bb_55a9_4ef6_8902_fda23604ecf8",
        //             "to_and_components" => [
        //                 [
        //                     "to" => [
        //                         91 . @$request->toMob
        //                     ],
        //                     "components" => [
        //                         "button_3" => [
        //                             "subtype" => "url",
        //                             "type" => "text",
        //                             "value" => @$request->btn_url
        //                         ],
        //                         // "header_1" => [
        //                         //     "type" => "text",
        //                         //     "value" => "Testing1"
        //                         // ],
        //                         // "body_1" => [
        //                         //     "type" => "text",
        //                         //     "value" => "value1"
        //                         // ],
        //                         // "body_2" => [
        //                         //     "type" => "text",
        //                         //     "value" => "value1"
        //                         // ],
        //                         // "body_3" => [
        //                         //     "type" => "text",
        //                         //     "value" => "value1"
        //                         // ]
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     ]
        // ]);

        $this->reqBody = json_encode([
            "integrated_number" => "91" . $request->fromMob,
            "content_type" => "template",
            "payload" => [
                "messaging_product" => "whatsapp",
                "type" => "template",
                "template" => [
                    "name" => $request->template_name,
                    "language" => [
                        "code" => $request->language,
                        "policy" => "deterministic"
                    ],
                    "namespace" => "68dc16bb_55a9_4ef6_8902_fda23604ecf8",
                    "to_and_components" => [
                        [
                            "to" => [
                                "91" . $request->toMob
                            ],
                            "components" => $components
                        ]
                    ]
                ]
            ]
        ]);

        $this->fullUrl = $this->setFullUrl('sendTemplate');

        $sendRequest = $this->sendCurlReq();

        // $sendRequest = $this->staticSendResponse();
        return $sendRequest;
    }

    function staticSendResponse()
    {
        $r['response'] = '{"status": "success", "hasError": false, "data": "Your request is in process, check delivery reports for status", "errors": null, "request_id": "5c45233982814d7c8ae10376335f0163"}';
        $r['code'] = 200;
        return $r;
    }

    function staticResponse()
    {
        // $r['response'] = '{"status": "success", "hasError": false, "data": {"message": "template creation in process.Please wait till the template is being approved from vendor", "template_id": "1929743611098423"}, "errors": null}';
        $r['response'] = '{"status": "fail", "hasError": true, "data": "Invalid parameter", "errors":"There is already English content for this template. You can create a new template and try again."}';
        $r['code'] = 200;
        return $r;
    }
}
