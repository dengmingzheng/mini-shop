@extends('system.layout.base')
@section('content')
    <div class="header_line">
        <h3>系统管理</h3>
        <ul class="tab-base">
            <li><a class="current"><span>菜单管理</span></a></li>
            <li><a href="{{url('admin/menus/create')}}"><span>添加菜单</span></a></li></ul>
    </div>


    <div class="content-group">
        <form method="get" id="formSearch">

            <table class="tb-type1 noborder search">
                <tbody>
                <tr>
                    <!-- 查询条件 -->
                    <th><label for="title">菜单名称</label></th>
                    <td><input type="text" value="{{request()->input('title')}}" name="title" class="txt"></td>

                    <th><label for="parent_id">所属分类</label></th>
                    <td>
                        <select id="parent_id" name="parent_id" class="valid">
                            <option value="0">--请选择--</option>
                            @if(!empty($navs))
                                @foreach($navs as $val)
                                    <option value="{{$val['id']}}" @if(request()->input('parent_id') == $val['id']) selected="selected" @endif>{{$val['title']}}</option>
                                    @if(!empty($val['children']))
                                        @foreach($val['children'] as $item)
                                            <option value="{{$item['id']}}" @if(request()->input('parent_id') == $item['id']) selected="selected" @endif>--{{$item['title']}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </td>

                    <td><a href="javascript:void(0);" id="searchSubmit" class="btn-search " title="查询">&nbsp;</a>
                    <td><a class="btns" id="searchReset" resetUrl="{{url('admin/menus')}}"><span>重置</span></a></td>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>

        <form method="post" id="form_admin" action="">

            <table class="table tb-type2 nobdb">
                <thead>
                <tr class="thead">
                    <th class="align-center"><input type="checkbox" class="checkAll"  name="chkVal"></th>
                    <th class="align-center">序号</th>
                    <th class="align-center">菜单名称</th>
                    <th class="align-center">上级菜单</th>
                    <th class="align-center">分组</th>
                    <th class="align-center">路由</th>
                    <th class="align-center">排序</th>
                    <th class="align-center">状态</th>
                    <th class="align-center">更新时间</th>
                    <th class="align-center">添加时间</th>
                    <th class="align-center">操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($list as $value)
                    <tr class="hover" style="background: rgb(255, 255, 255);">
                        <td class="align-center"><input name="ids[]" type="checkbox" value="{{$value['id']}}" class="checkItem"></td>
                        <td class="align-center">{{$loop->index+1}}</td>
                        <td class="align-center">{{$value['title']}}</td>
                        <td class="align-center">@if(!empty($value['parent'])) {{$value['parent']['title']}} @else 顶级菜单 @endif</td>
                        <td class="align-center">{{$value['group']}}</td>
                        <td class="align-center">{{$value['url']}}</td>
                        <td class="align-center">{{$value['sort']}}</td>
                        <td class="align-center">{{$value['is_show'] ? '显示' : '隐藏'}}</td>
                        <td class="align-center">{{$value['updated_at']}}</td>
                        <td class="align-center">{{$value['created_at']}}</td>

                        <td class="align-center">
                            <a href="{{url('admin/menus/edit?id=')}}{{$value['id']}}">编辑</a> |
                            <a href="JavaScript:void(0)" deleteId="{{$value['id']}}" deleteUrl="{{url('admin/menus/del')}}" class="delete">删除</a></td>
                    </tr>

                @empty
                    <tr class="hover">
                        <td colspan="10" class="align-center">没有数据</td>

                    </tr>
                @endforelse

                </tbody>
                <tfoot class="tfoot">
                <tr>
                    <td class="align-center"><input type="checkbox" class="checkAll" name="chkVal"></td>

                    <td colspan="16"><label for="checkallBottom">全选</label>&nbsp;&nbsp;
                        <a href="JavaScript:void(0);" class="btn delAll" deleteUrl="{{url('admin/menus/del')}}"><span>删除</span></a>

                        <div class="pagination">
                        {!! $page !!}
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
@endsection
