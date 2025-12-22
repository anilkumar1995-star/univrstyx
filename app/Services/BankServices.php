<?php

namespace App\Services;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\Permission;

class BankServices
{
    private $authKey, $authSecret, $endPoint, $baseUrl = "", $header = [], $fullUrl, $method, $reqBody;

    public function __construct()
    {
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('bankverify');
        if ($getApiCred['status']) {
            $this->authKey = @$getApiCred['apidata']['username'];
            $this->authSecret = @$getApiCred['apidata']['password'];
            $this->baseUrl = @$getApiCred['apidata']['url'];
            $this->header = [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$this->authKey:$this->authSecret")
            ];
        }
    }

    public function setFullUrl($method)
    {
        if ($method == 'bankVerify')
            return $this->baseUrl . '/v1/service/verification/bank/verify';
        return "";
    }

    public function sendCurlReq()
    {
        $result = Permission::curl(@$this->fullUrl, @$this->method, $this->reqBody, $this->header, "yes", @$this->endPoint, @$this->reqBody->mobile);
        return $result;
    }

    //-------------- API Integration Bank Verify Service --------------------------------

    public function doBankVerify($request)
    {
      $request->validate([
        'ac' => 'required|digits_between:9,18', 
        'ifsc' => 'required|regex:/^[A-Za-z]{4}[a-zA-Z0-9]{7}$/', 
    ]);
        $this->endPoint = "bankVerify";
        $this->method = "POST";

        $this->reqBody = json_encode([
            "clientRefId"=> $request->clientrefId,
            "accountNumber"=> $request->ac,
            "ifsc"=> $request->ifsc,
        ]);

        $this->fullUrl = $this->setFullUrl('bankVerify');

        $sendRequest = $this->sendCurlReq();

    //    $sendRequest = $this->staticVerifyResponse();
        return $sendRequest;
    }

    function staticVerifyResponse()
    {
        $r['response'] = '{
                "code": "200",
                "message": "Record found successful.",
                "status": "SUCCESS",
                "data": {
                    "isValid": true,
                    "accountHolderName": "SUNIL KUMAR SO SAHISH KUMAR",
                    "accountNumber": "47530100003095",
                    "accountIfsc": "BARB0TOROMA"
                }
            }';
        $r['code'] = 200;
        return $r;
    }
}
