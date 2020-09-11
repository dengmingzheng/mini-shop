<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
                    'role_name' =>['required','max:30','unique:roles'],
                ];
            }

            case 'PUT':{
                return [
                    'role_name' =>['required','max:30'],
                    'id'=>['required','integer']
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
            'role_name.required'=>'请输入角色名称',
            'role_name.max'=>'角色名称最大长度为30位',
            'role_name.unique'=>'角色名称已被占用',
            'id.required' => '修改失败',
            'id.integer' => '修改失败',
        ];
    }
}
