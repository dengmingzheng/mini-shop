<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Banner;

class BannerRequest extends FormRequest
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
                        'name' => [
                            'required',
                            'max:30',
                            function ($attribute, $value, $fail) {
                                if (Banner::where(['name' => $value])->first()) {
                                    return $fail('Banner图名称已存在');
                                }

                            }
                        ],
                        'position' => ['nullable', 'max:30'],
                        'img' => ['nullable', 'image', 'max:1024'],
                        'link_type' => ['required', 'boolean'],
                        'link_url' => ['nullable', 'max:100'],
                        'sort' => ['required', 'integer'],
                        'status' => ['required', 'boolean']
                    ];
                }

            case 'PUT':
                {
                    return [
                        'name' => ['required', 'max:30',],
                        'position' => ['nullable', 'max:30'],
                        'img' => ['nullable', 'image', 'max:1024'],
                        'link_type' => ['required', 'boolean'],
                        'link_url' => ['nullable', 'max:100'],
                        'sort' => ['required', 'integer'],
                        'status' => ['required', 'boolean'],
                        'id' => ['required', 'integer'],
                    ];
                }

            case 'DELETE':
                {
                    return [];
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
            'name.required' => '请输入Banner名称',
            'name.max' => 'Banner名称最大长度为30位',
            'position.max' => '位置最大长度为30位',
            'img.image' => '上传的不是图片',
            'img.max' => '上传图片不能大于1M',
            'link_type.required' => '请选择链接类型',
            'link_type.boolean' => '链接类型参数错误',
            'link_url.max' => '链接地址最大长度为100位',
            'sort.required' => '请输入排序',
            'sort.integer' => '排序参数错误',
            'status.required' => '请选择状态',
            'status.boolean' => '状态参数错误',
            'id.required' => '参数错误!',
            'id.integer' => '参数错误!',
        ];
    }
}
