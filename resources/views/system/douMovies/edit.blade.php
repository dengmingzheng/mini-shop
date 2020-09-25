@extends('system.layout.base')
@section('content')
    <div class="header_line">
        <h3>豆瓣管理</h3>
        <ul class="tab-base">
            <li><a href="{{url('admin/douban/movies')}}"><span>影视列表</span></a></li>
            <li><a class="current"><span>编辑影视</span></a></li>
        </ul>
    </div>

    <div class="content-group">
        <form method="POST" action="{{url('admin/douban/movies/edit')}}" id="form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{$detail['id']}}"/>
            <table class="table tb-type2">
                <tbody>
                <tr class="noborder">
                    <td colspan="2"><label class="validation">中文名称(必填):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('ch_title',$detail['ch_title'])}}"  name="ch_title" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('ch_title')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">英文名称(必填):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('zh_title',$detail['zh_title'])}}"  name="zh_title" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('zh_title')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">别名:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('another_name',$detail['another_name'])}}"  name="another_name" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('another_name')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">封面(必传):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                       <span class="type-file-show">
                            <img class="show_image" src="/system/images/preview.png">
                            <div class="type-file-preview">
                                <img src="{{$detail['image_path']}}">
                            </div>
                        </span>
                        <span class="type-file-box">
                            <input name="image_path" type="file" value="{{$detail['image_path']}}" >
                        </span>
                    </td>
                    <td class="vatop tips">{{$errors->first('image_path')}} </td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">所属分类(必选):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <select id="category_id" name="category_id" class="valid">
                            <option value="">--请选择上级菜单--</option>
                            @if(!empty($categoryList))
                                @foreach($categoryList as $val)
                                    <option value="{{$val['id']}}" @if(old('category_id',$detail['category_id']) == $val['id']) selected="selected" @endif>{{$val['title']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="vatop tips">{{$errors->first('category_id')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">评分:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('rate',$detail['rate'])}}"  name="rate" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('rate')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">评价人数:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('rate_num',$detail['rate_num'])}}"  name="rate_num" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('rate_num')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">评论人数:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('comment_num',$detail['comment_num'])}}"  name="comment_num" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('comment_num')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">演员(必填):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('actors',$detail['actors'])}}"  name="actors" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('actors')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">时长(必填):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('length_time',$detail['length_time'])}}"  name="length_time" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('length_time')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">发行年份(必填):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('year',$detail['year'])}}" id="chooseYear"  name="year" class="txt" autocomplete="off"></td>
                    <td class="vatop tips">{{$errors->first('year')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">上映时间(必填):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('is_use',$detail['is_use'])}}"  name="is_use" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('is_use')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">类型(必选):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform" style="width: 1200px;">
                        @if(!empty($typeList))
                            @foreach($typeList as $value)
                                <input name="types[]" type="checkbox" @if(in_array($value['id'],old('types',$detail['types']))) checked="checked" @endif value="{{$value['id']}}"/>{{$value['title']}}
                            @endforeach
                        @endif
                    </td>
                    <td class="vatop tips">{{$errors->first('types')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">所属地区(必选):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <select id="region_id" name="region_id" class="valid">
                            <option value="">--请选择--</option>
                            @if(!empty($regionList))
                                @foreach($regionList as $val)
                                    <option value="{{$val['id']}}" @if(old('region_id',$detail['region_id']) == $val['id']) selected="selected" @endif>{{$val['title']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="vatop tips">{{$errors->first('region_id')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">标签(必选):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform" style="width: 1200px;">
                        @if(!empty($tagList))
                            @foreach($tagList as $value)
                                <input name="tags[]" type="checkbox" @if(in_array($value['id'],old('tags',$detail['tags']))) checked="checked" @endif value="{{$value['id']}}"/>{{$value['title']}}
                            @endforeach
                        @endif
                    </td>
                    <td class="vatop tips">{{$errors->first('tags')}}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr class="tfoot">
                    <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span>提交</span></a></td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
@endsection

@section('script')
    <script src="/system/js/laydate/laydate.js"></script>
    <script>
        laydate.render({
            elem: '#chooseYear', //指定元素
            type: 'year'
        });
    </script>
@endsection