@extends('system.layout.base')
@section('content')
    <div class="header_line">
        <h3>系统管理</h3>
        <ul class="tab-base">
            <li><a href="{{url('admin/menus')}}"><span>菜单管理</span></a></li>
            <li><a class="current"><span>添加菜单</span></a></li></ul>
    </div>


    <div class="content-group">
        <form method="post" action="{{url('admin/menus/create')}}" id="form">
            @csrf
            <table class="table tb-type2">
                <tbody>
                <tr class="noborder">
                    <td colspan="2"><label class="validation">菜单名称:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('title')}}"  name="title" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('title')}}</td>
                </tr>

                <tr class="">
                    <td colspan="2" class="required"><label class="validation" for="">上级菜单:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <select id="parent_id" name="parent_id" class="valid">
                            <option value="">--请选择上级菜单--</option>
                            @if(!empty($navs))
                                @foreach($navs as $val)
                                    <option value="{{$val['id']}}" @if(old('parent_id') == $val['id']) selected="selected" @endif>{{$val['title']}}</option>
                                    @if(!empty($val['children']))
                                        @foreach($val['children'] as $item)
                                            <option value="{{$item['id']}}" @if(old('parent_id') == $item['id']) selected="selected" @endif>--{{$item['title']}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </select></td>
                    <td class="vatop tips">{{$errors->first('parent_id')}}</td>
                </tr>

                <tr>
                    <td colspan="2"><label class="validation" for="">分组:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('group')}}"  name="group" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('group')}}</td>
                </tr>

                <tr>
                    <td colspan="2" class="required"><label class="validation" for="">路由:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('url')}}"  name="url" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('url')}}</td>
                </tr>

                <tr>
                    <td colspan="2" class="required"><label class="validation" for="">排序:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('sort')}}"  name="sort" class="txt"></td>
                    <td class="vatop tips">@if(!empty($errors->first('sort'))) {{$errors->first('sort')}} @else 排序的数值越小越靠前 @endif</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2" class="required"><label>是否显示菜单:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="radio" value="0" name="is_show" checked="checked">不显示 <input type="radio" value="1" name="is_show">显示
                    </td>
                    <td class="vatop tips"></td>
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
