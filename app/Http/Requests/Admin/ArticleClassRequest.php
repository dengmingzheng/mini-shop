<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticleClassRequest extends FormRequest
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
                    'title' =>['required','max:100','unique:article_classes'],
                    'parent_id' =>['nullable','integer'],
                    'sort' =>['required','integer']
                ];
            }

            case 'PUT':{
                return [
                    'title' =>['required','max:100'],
                    'parent_id' =>['nullable','integer'],
                    'sort' =>['required','integer'],
                    'id' =>['required','integer']
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
            'title.required'=>'请输入分类名称',
            'title.max'=>'分类名称最大长度为100位',
            'title.unique'=>'分类名称已存在',
            'parent_id.integer'=>'所属分类必须为整数',
            'sort.required'=>'请选择排序',
            'sort.integer'=>'排序必须为整数',
            'id.required'=>'参数错误',
            'id.integer'=>'参数错误',
        ];
    }
}
