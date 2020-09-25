@extends('system.layout.base')
@section('content')
<div class="header_line">
    <h3>网站管理</h3>
    <ul class="tab-base">
        <li><a href="{{url('admin/banners')}}"><span>Banner管理</span></a></li>
        <li><a class="current"><span>编辑Banner</span></a></li>
    </ul>
</div>

<div class="content-group">
    <form method="POST" action="{{url('admin/banners/edit')}}" id="form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$banner['id']}}"/>
        <table class="table tb-type2">
            <tbody>
            <tr class="noborder">
                <td colspan="2"><label class="validation">Banner名称(必填):</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform" style="width: 400px;"><input type="text" value="{{ $banner['name'] }}"  name="name" class="txt"></td>
                <td class="vatop tips">{{$errors->first('name')}}{{$errors->first('id')}}</td>
            </tr>

            <tr class="">
                <td colspan="2" class="required"><label class="validation" for="">Banner类型:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform">
                    <select id="type" name="type" class="valid">
                        <option value="">--请选择--</option>
                        @foreach($types as $key=>$val)
                            <option value="{{$key}}" @if(old('type',$banner['type']) ==$key) selected="selected" @endif>{{$val}}</option>
                        @endforeach
                    </select></td>
                <td class="vatop tips">{{$errors->first('type')}}</td>
            </tr>

            <tr>
                <td colspan="2"><label class="validation" for="">位置:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform" style="width: 400px;"><input type="text" value="{{$banner['position']}}"  name="position" class="txt"></td>
                <td class="vatop tips">{{$errors->first('position')}}</td>
            </tr>

            <tr class="noborder">
                <td colspan="2"><label class="validation">Banner图片:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform" style="width: 400px;">
                        <span class="type-file-show">
                            <img class="show_image" src="{{asset('system/images/preview.png')}}">
                            <div class="type-file-preview">
                                <img src="{{$banner['image_src']}}">
                            </div>
                        </span>
                        <span class="type-file-box">
                            <input name="img" type="file" value="" >
                        </span>
                </td>
                <td class="vatop tips">{{$errors->first('image_src')}} </td>
            </tr>

            <tr>
                <td colspan="2" class="required"><label class="validation" for="">链接地址:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform" style="width: 400px;"><input type="text" value="{{ $banner['navigator_url'] }}"  name="navigator_url" class="txt"></td>
                <td class="vatop tips">{{$errors->first('navigator_url')}}</td>
            </tr>

            <tr>
                <td colspan="2" class="required"><label class="validation" for="">链接类型:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform" style="width: 400px;"><input type="text" value="{{ $banner['open_type'] }}"  name="open_type" class="txt"></td>
                <td class="vatop tips">{{$errors->first('open_type')}}</td>
            </tr>

            <tr>
                <td colspan="2" class="required"><label class="validation" for="">排序:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform" style="width: 400px;"><input type="text" value="{{ $banner['sort'] }}"  name="sort" class="txt"></td>
                <td class="vatop tips">{{$errors->first('sort')}} </td>
            </tr>

            <tr class="noborder">
                <td colspan="2" class="required"><label>状态:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform" style="width: 400px;">
                    <input type="radio" value="0" name="status" @if($banner['status'] == 0) checked="checked" @endif>禁用 <input type="radio" value="1" name="status" @if($banner['status'] == 1) checked="checked" @endif>启用
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
