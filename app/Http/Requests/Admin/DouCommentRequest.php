<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class DouCommentRequest extends BaseRequest
{
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

                ];
            }

            case 'PUT':{
                return [

                ];
            }

            case 'DELETE':{
                return [
                    'ids' =>['required','array',]
                ];
            }

            default:{
                return [];
            }

        }
    }

    public function messages()
    {
        return [
            'ids.required'=>'请选择要删除的数据',
            'ids.array'=>'参数错误'
        ];
    }
}
