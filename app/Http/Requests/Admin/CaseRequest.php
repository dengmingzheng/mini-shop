<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CaseRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                {
                    return [
                        'name' => ['required', 'max:50', 'unique:cases'],
                        'type' => ['nullable', 'integer'],
                        'author'=>['nullable','max:50'],
                        'industry_ids'=>['nullable','max:20'],
                        'logo'=>['nullable','max:1024','image'],
                        'show_img'=>['nullable','max:255'],
                        'sort'=>['required','integer']
                    ];
                }

            case 'PUT':
                {
                    return [

                    ];
                }

            default:
                {
                    return [];
                }
        }
    }

    public function messages()
    {
        return [
            'name.required'=>'请输入案例名称',
            'name.max'=>'案例名称最大长度为50位',
            'name.unique'=>'案例名称已存在',
            'type.integer'=>'案例所属类型参数错误',
            'author.max'=>'作者最大长度为50位',
            'industry_ids.max'=>'所属行业最大长度为20位',
            'logo.max'=>'案例Logo最大1M',
            'logo.image'=>'上传的不是图片',
            'show_img.max'=>'案例展示图片最大长度为255位',
            'sort.required'=>'请输入排序',
            'sort.integer'=>'排序参数错误',
        ];
    }
}
