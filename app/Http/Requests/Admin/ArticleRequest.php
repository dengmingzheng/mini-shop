<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
                    'title' =>['required','max:100','unique:articles'],
                    'ac_id' =>['required','integer'],
                    'is_show' =>['required','boolean'],
                    'sort' =>['required','integer'],
                    'author'=>['required','max:30'],
                ];
            }

            case 'PUT':{
                return [
                    'title' =>['required','max:50'],
                    'ac_id' =>['required','integer'],
                    'is_show' =>['required','boolean'],
                    'sort' =>['required','integer'],
                    'author'=>['required','max:30'],
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
            'title.max'=>'分类名称最大长度为50位',
            'title.unique'=>'分类名称已存在',
            'ac_id.required'=>'请选择所属分类',
            'ac_id.integer'=>'所属分类必须为整数',
            'is_show.required'=>'请选择状态',
            'is_show.boolean'=>'状态参数错误',
            'sort.required'=>'请选择排序',
            'sort.integer'=>'排序必须为整数',
            'id.required'=>'参数错误',
            'id.integer'=>'参数错误',
            'author.required'=>'请输入作者',
            'author.max'=>'作者最大长度为30位',
        ];
    }
}
