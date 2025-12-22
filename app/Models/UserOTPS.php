<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserOTPS extends Model
{
    use HasFactory;

    protected $table = 'user_otps';

    public $tablename;

    function getOTPdata($user_id, $searchType)
    {
        $user = self::where('user_id', $user_id)->where('otp_type', $searchType)->first();
        if (!$user) {
            return false;
        } else {
            return $user;

        }
    }

    static function updateOTPData($user_id, $encyOtp, $latlong, $ip, $otpType)
    {
        $getUser = self::getOTPdata($user_id, $otpType);
        if (!$getUser) {
            // Insert new OTP data
            $insertData = [
                "user_id" => $user_id,
                "otp" => $encyOtp,
                "otp_resend_attemps" => 0,
                "is_otp_verify" => 0,
                "lat_long" => $latlong,
                "ip" => $ip
            ];
            try {
                $isertData = self::insert($insertData);
                if ($isertData) {
                    return true;
                } else {
                    return false;

                }
            } catch (Exception $ex) {
                return false;
            }
        } else {
            $updateData = [
                "otp" => $encyOtp,
                "otp_resend_attemps" => (int) $getUser->otp_resend_attemps + (int) 1,
                "lat_long" => $getUser->lat_long . "||" . $latlong,
                "ip" => $$getUser->ip . "||" . $ip,
                "updated_at" => date('Y-m-d H:i:s')
            ];
            try {
                $isertData = self::where('user_id', $user_id)->where('type', $otpType)->update($updateData);
                if ($isertData) {
                    return true;
                } else {
                    return false;
                }

            } catch (Exception $ex) {
                return false;
            }


        }
    }

    function updateOTPVerified($user_id, $updateType = '', $otpType)
    {
        if ($updateType == "login") {
            $updateData['is_otp_verify'] = 1;
            $updateData['last_login'] = date('Y-m-d H:i:s');
        } else {
            $updateData['is_otp_verify'] = 0;
            $updateData['update_at'] = date('Y-m-d H:i:s');
        }


        $check = self::where('user_id', $user_id)->where('otp_type', $otpType)->update($updateData);
        if ($check) {
            return true;
        } else {
            return false;
        }

    }
}
