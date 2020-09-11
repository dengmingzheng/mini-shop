<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
        switch ($this->method()){
            case 'POST':{
                return [
                    'login_name' =>['required','max:30','unique:accounts'],
                    'password' =>['required','min:6','confirmed'],
                    'user_name' =>['required','max:30']
                ];
            }

            case 'PUT':{
                return [
                    'user_name' =>['required','max:30'],
                    'password' =>['nullable','min:6','confirmed'],
                ];
            }

            case 'DELETE':{
                return [];
            }

            default:{
                return [];
            }

        }
    }

    public function messages()
    {
        return [
            'login_name.required'=>'请输入用户名',
            'login_name.max'=>'用户名最大长度为30位',
            'login_name.unique'=>'用户名已被占用',
            'password.required'=>'请输入密码',
            'password.min'=>'密码最小长度为6位',
            'password.confirmed'=>'密码和确认密码不一致',
            'user_name.required'=>'请输入昵称',
            'user_name.max'=>'昵称最大长度为30位',
        ];
    }
}
