<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class userUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' 	=> 	'required|email',
            'username' 	=> 	'required|alpha_num',
            'name'		=> 	'required',
        ];
    }
    public function messages(){
        return [
            'email.required' => 	'กรุณาทำการป้อน E-mail',
            'email.email' 	=> 	'รูปแบบ Email ไม่ถูกต้อง',
            'username.required' 	=> 	'กรุณาทำการป้อน Username',
            'username.alpha_num' 	=> 	'Username ต้องประกอบไปด้วย A-Z, a-z , 1-9 เที่านั้น ',
            'name.required'		=> 	'กรุณาป้อนชื่อ',
        ];
    }

}
