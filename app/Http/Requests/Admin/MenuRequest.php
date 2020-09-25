<?php

namespace App\Http\Requests\Admin;

use App\Models\Menu;
use App\Http\Requests\BaseRequest;

class MenuRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            // CREATE
            case 'POST':
                {
                    return [
                        'title' => [
                            'required',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                if (Menu::where(['title'=>$value])->first()) {
                                    return $fail('菜单名称已存在');
                                }

                            }
                        ],
                        'group' => ['required','max:20'],
                        'url' => ['required','max:50'],
                        'sort' => ['required','between:0,255'],
                        'is_show' => ['required', 'boolean'],
                    ];
                }
            // UPDATE
            case 'PUT':
                {
                    return [
                        'id'=>['required','integer'],
                        'title' => ['required', 'max:50'],
                        'group' => ['required','max:20'],
                        'url' => ['required','max:50'],
                        'sort' => ['required','between:0,255'],
                        'is_show' => ['required', 'boolean'],
                    ];
                }

            case 'DELETE':
                {
                    return [
                        'ids'=>['required','array'],
                    ];
                }
            default:
                {
                    return [];
                };
        }
    }

    public function messages()
    {
        return [
            'title.required' => '请填写菜单名称',
            'title.max' => '菜单名称最大长度为50位',
            'group.required' => '请填写分组标识',
            'group.max' => '分组标识最大长度为20位',
            'url.max' => '路由最大长度为50位',
            'url.required' => '请填写路由',
            'sort.required' => '请填写排序',
            'sort.between' => '排序在0-255之间',
            'is_show.required' => '请选择是否显示菜单',
            'is_show.boolean' => '参数错误',
            'id.required' => '参数错误',
            'id.integer' => '参数错误',
        ];
    }
}
