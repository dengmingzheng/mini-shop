@extends('system.layout.base')
@section('content')
    <div class="header_line">
        <h3>豆瓣管理</h3>
        <ul class="tab-base">
            <li><a href="{{url('admin/douban/tags')}}"><span>标签列表</span></a></li>
            <li><a class="current"><span>添加标签</span></a></li>
        </ul>
    </div>

    <div class="content-group">
        <form method="POST" action="{{url('admin/douban/tags/create')}}" id="form">
            @csrf

            <table class="table tb-type2">
                <tbody>
                <tr class="noborder">
                    <td colspan="2"><label class="validation">标签名称(必填):</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{old('title')}}"  name="title" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('title')}}</td>
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
