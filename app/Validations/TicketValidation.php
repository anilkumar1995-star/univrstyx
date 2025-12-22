<?php
namespace Validations;

use App\Models\UserService;
use Illuminate\Support\Facades\Validator;

class TicketValidation {

	protected $data;
	public function __construct($data){
		$this->data = $data;
	}

        /**
     * validation function
     *
     * @param [type] $key
     * @return void
     */
    private function validation($key)
    {
        $validation = [
            'required'  => 'required',
            'mobile'     => ['required', 'digits_between:10,18'],
            'mobiles' => ['required', 'digits_between:8,18'],
            'aadhaar'     => ['required', 'integer', 'digits:12'],
            'pan_no'     => ['required', 'string', 'size:10'],
            'email'     => ['required', 'email'],
            'string'     => ['required', 'string'],
            'file' => 'mimes:jpeg,jpg,png|max:10000'
           
        ];
        return $validation[$key];
    }

    public static function init($request, $method)
    {
        $resp['status'] = false;
        $resp['message'] = "";
        $validation = new TicketValidation($request);
        $validator = $validation->$method();
        $validator->after(function ($validator) use ($request) {
           
        });

        if ($validator->fails()) {
            $resp['message'] = json_decode(json_encode($validator->errors()), true);
            return $resp;
        } else {
            $resp['status'] = true;
            return $resp;
        }
    }

	public function create()
	{
        $validations = [
            'category'      => $this->validation('string'),
            'subject'      => $this->validation('string'),
            'description' => $this->validation('string'),
             'priority' => $this->validation('string'),
             'name' => $this->validation('string'),
             'platform' => $this->validation('string'),
             'email' => $this->validation('email'),
            'file' => $this->validation('file'),
        ];
        $validator = Validator::make($this->data->all(), $validations, []);
        return $validator;
	}

}


?>