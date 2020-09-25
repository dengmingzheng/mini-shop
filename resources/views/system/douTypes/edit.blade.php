@extends('system.layout.base')
@section('content')
    <div class="header_line">
        <h3>豆瓣管理</h3>
        <ul class="tab-base">
            <li><a href="{{url('admin/douban/types')}}"><span>类型列表</span></a></li>
            <li><a class="current"><span>编辑类型</span></a></li>
        </ul>
    </div>

    <div class="content-group">
        <form method="POST" action="{{url('admin/douban/types/edit')}}" id="form">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{$detail['id']}}"/>
            <table class="table tb-type2">
                <tbody>
                <tr class="noborder">
                    <td colspan="2"><label class="validation">类型名称:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="{{request()->input('title',$detail['title'])}}"  name="title" class="txt"></td>
                    <td class="vatop tips">{{$errors->first('title')}}{{$errors->first('id')}}</td>
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
