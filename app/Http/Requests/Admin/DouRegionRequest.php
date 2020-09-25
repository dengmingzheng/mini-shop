<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class DouRegionRequest extends BaseRequest
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
                    'title' =>['required','max:60','unique:dou_regions']
                ];
            }

            case 'PUT':{
                return [
                    'title' =>['required','max:60'],
                    'id' =>['required','integer',],
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
            'title.required'=>'请输入地区名称',
            'title.max'=>'地区名称最大长度为60位',
            'title.unique'=>'地区名称已被占用',
            'id.required'=>'参数错误',
            'id.integer'=>'参数错误',
            'ids.required'=>'请选择要删除的数据',
            'ids.array'=>'参数错误'
        ];
    }
}
