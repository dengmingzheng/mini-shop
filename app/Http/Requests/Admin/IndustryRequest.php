<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class IndustryRequest extends FormRequest
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
                    'name' =>['required','max:50','unique:industries'],
                    'sort' => ['required', 'integer']
                ];
            }

            case 'PUT':{
                return [
                    'name' =>['required','max:50'],
                    'sort' => ['required', 'integer'],
                    'id' => ['required', 'integer'],
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
            'name.required'=>'请输入行业分类名称',
            'name.max'=>'行业分类名称最大长度为50位',
            'name.unique'=>'行业分类名称已被占用',
            'id.required' => '参数错误',
            'id.integer' => '参数错误',
            'sort.required' => '请输入排序',
            'sort.integer' => '排序参数错误',
        ];
    }
}
