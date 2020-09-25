<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class DouMovieRequest extends BaseRequest
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
                $where = [
                    'ch_title'=>request()->input('ch_title'),
                    'zh_title'=>request()->input('ch_title')
                ];
                return [
                    'ch_title' =>['nullable','max:30','required_without:zh_title','unique:dou_movies',
                        Rule::unique('dou_movies')
                            ->where(function ($query) use ($where) {
                                return $query->where($where);
                            })
                    ],
                    'zh_title' =>['nullable','max:30','required_without:ch_title'],
                    'another_name' =>['nullable','max:100'],
                    'category_id' =>['required','integer'],
                    'types' =>['nullable','array'],
                    'region_id' =>['required','integer'],
                    'tags' =>['nullable','array'],
                    'rate' =>['nullable','numeric','between:0,10'],
                    'rate_num' =>['nullable','integer'],
                    'comment_num' =>['nullable','integer'],
                    'actors' =>['required','max:200'],
                    'length_time' =>['required','max:60'],
                    'year' =>['required','size:4'],
                    'is_use' =>['required','max:100'],
                    'image_path' =>['required','mimes:jpeg,jpg,png,gif,webp'],
                ];
            }

            case 'PUT':{
                return [
                    'ch_title' =>['required','max:30'],
                    'zh_title' =>['required','max:30'],
                    'another_name' =>['nullable','max:100'],
                    'category_id' =>['required','integer'],
                    'types' =>['nullable','array'],
                    'region_id' =>['required','integer'],
                    'tags' =>['nullable','array'],
                    'rate' =>['nullable','numeric','between:0,10'],
                    'rate_num' =>['nullable','integer'],
                    'comment_num' =>['nullable','integer'],
                    'actors' =>['required','max:200'],
                    'length_time' =>['required','max:60'],
                    'year' =>['required','size:4'],
                    'is_use' =>['required','max:100'],
                    'image_path' =>['nullable','mimes:jpeg,jpg,png,gif,webp'],
                    'id' =>['required','integer',],
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
            'ch_title.required_without'=>'请输入中文名称',
            'ch_title.max'=>'中文名称最大长度为30位',
            'ch_title.unique'=>'中文名称或英文名称已被占用',
            'zh_title.required_without'=>'请输入英文名称',
            'zh_title.max'=>'英文名称最大长度为30位',
            'another_name.max'=>'别名最大长度为100位',
            'category_id.required'=>'请选择分类名称',
            'category_id.integer'=>'分类名称参数格式错误',
            'types.array'=>'类型参数格式错误',
            'region_id.required'=>'请选择地区',
            'region_id.integer'=>'地区参数格式错误',
            'tags.array'=>'标签参数格式错误',
            'rate.numeric'=>'评分必须为数值',
            'rate.between'=>'超出评分范围,必须为0-10',
            'rate_num.integer'=>'评价人数必须为整形',
            'comment_num.integer'=>'评论人数必须为整形',
            'actors.required'=>'请输入演员',
            'actors.max'=>'演员最大长度为200位',
            'length_time.required'=>'请输入时长',
            'length_time.max'=>'时长最大长度为60位',
            'year.required'=>'请选择发行年份',
            'year.size'=>'发行年份长度必须为4位',
            'is_use.required'=>'请输入上映时间',
            'is_use.max'=>'上映时间最大长度为100位',
            'image_path.required'=>'请上传封面',
            'image_path.mimes'=>'上传的封面不是图片',
            'id.required'=>'参数错误',
            'id.integer'=>'参数错误'
        ];
    }
}
