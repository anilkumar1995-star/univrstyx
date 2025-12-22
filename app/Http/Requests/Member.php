<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Member extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Auth::check()) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $post)
    {
        $data = [
            'name'      => 'sometimes|required',
            'mobile'    => 'sometimes|required|numeric|digits:10|unique:users,mobile'.($post->id != "new" ? ",".$post->id : ''),
            'email'     => 'sometimes|required|email|unique:users,email'.($post->id != "new" ? ",".$post->id : ''),
            'address'=> 'sometimes|required',
            'role_id'  => 'sometimes|required|numeric',
        ];

        if (\Myhelper::can('member_password_reset')) {
            $data['password'] = "sometimes|required|min:8";
        }else{
            $data['password'] = "sometimes|required|min:8|confirmed";
        }

        if($post->has('oldpassword')){
            $data['password'] = $data['password']."|different:oldpassword";
        }
        return $data;
    }
}
