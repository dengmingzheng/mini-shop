<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class DouCategoryRequest extends BaseRequest
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
                    'title' =>['required','max:20','unique:dou_categories']
                ];
            }

            case 'PUT':{
                return [
                    'title' =>['required','max:20'],
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
            'title.required'=>'请输入分类名称',
            'title.max'=>'分类名称最大长度为20位',
            'title.unique'=>'分类名称已被占用',
            'id.required'=>'参数错误',
            'id.integer'=>'参数错误',
            'ids.required'=>'请选择要删除的数据',
            'ids.array'=>'参数错误'
        ];
    }
}
