@extends('system.layout.base')
@section('content')
    <div class="header_line">
        <h3>网站管理</h3>
        <ul class="tab-base">
            <li><a href="{{url('admin/banners')}}"><span>Banner管理</span></a></li>
            <li><a class="current"><span>添加Banner</span></a></li>
        </ul>
    </div>

    <div class="content-group">
        <form method="POST" action="{{url('admin/banners/create')}}" id="form" enctype="multipart/form-data">
            @csrf

            <table class="table tb-type2">
                <tbody>
                <tr class="noborder">
                    <td colspan="2"><label class="validation">Banner名称(必填):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('name')}}"  name="name" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('name')}}</td>
                </tr>

                <tr>
                    <td colspan="2"><label class="validation" for="">位置:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('position')}}"  name="position" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('position')}}</td>
                </tr>

                <tr class="noborder">
                    <td colspan="2"><label class="validation">Banner图片:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="file" value="" name="image_src" class="txt">
                    </td>
                    <td class="vatop tips">{{$errors->first('image_src')}} </td>
                </tr>

                <tr>
                    <td colspan="2" class="required"><label class="validation" for="">链接地址:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('navigator_url')}}"  name="navigator_url" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('navigator_url')}}</td>
                </tr>

                <tr>
                    <td colspan="2" class="required"><label class="validation" for="">链接打开方式:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('open_type')}}"  name="open_type" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('open_type')}}</td>
                </tr>

                <tr>
                    <td colspan="2" class="required"><label class="validation" for="">排序:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('sort',255)}}"  name="sort" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('sort')}} </td>
                </tr>

                <tr class="noborder">
                    <td colspan="2" class="required"><label>状态:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="radio" value="0" name="status" @if(old('status') == 0) checked="checked" @endif >禁用 <input type="radio" value="1" name="status" @if(old('status') == 1) checked="checked" @endif>启用
                    </td>
                    <td class="vatop tips">{{$errors->first('status')}}</td>
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
