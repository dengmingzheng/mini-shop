<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class LinkRequest extends BaseRequest
{
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
                        'name' => ['required', 'max:50', 'unique:links'],
                        'url' => ['nullable', 'max:100', 'url'],
                        'sort' => ['required', 'integer'],
                    ];
                };

            case 'PUT':
                {
                    return [
                        'id' => ['required', 'integer'],
                        'name' => ['required', 'max:50'],
                        'url' => ['nullable', 'max:100', 'url'],
                        'sort' => ['required', 'integer'],
                    ];
                };

            default :
                {
                    return [];
                }
        }
    }

    public function messages()
    {
        return [
            'name.required' => '请输入链接标题',
            'name.max' => '链接标题最大长度为50位',
            'name.unique' => '链接标题已存在',
            'url.max' => '链接网址最大长度为100位',
            'url.url' => '不是一个有效的链接网址',
            'sort.required' => '请输入排序',
            'sort.integer' => '排序格式错误',
            'id.required' => '添加失败',
            'id.integer' => '添加失败',
        ];
    }
}
