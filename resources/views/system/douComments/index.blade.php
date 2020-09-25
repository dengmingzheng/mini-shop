@extends('system.layout.base')
@section('content')
    <div class="header_line">
        <h3>豆瓣管理</h3>
        <ul class="tab-base">
            <li><a class="current"><span>评论管理</span></a></li>
        </ul>
    </div>


    <div class="content-group">

        <form method="get" id="formSearch">
            <table class="tb-type1 noborder search">
                <tbody>
                <tr>
                    <!-- 查询条件 -->
                    <th><label for="title">中文名称:</label></th>
                    <td><input type="text" value="{{request()->input('title')}}" name="title" class="txt"></td>

                    <th><label for="title">评论人:</label></th>
                    <td><input type="text" value="{{request()->input('name')}}" name="name" class="txt"></td>

                    <th><label for="category_id">所属分类:</label></th>
                    <td>
                        <select id="category_id" name="category_id" class="valid">
                            <option value="">--请选择--</option>
                            @if(!empty($categoryList))
                                @foreach($categoryList as $val)
                                    <option value="{{$val['id']}}" @if(request()->input('category_id') == $val['id']) selected="selected" @endif>{{$val['title']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>


                    <td><a href="javascript:void(0);" id="searchSubmit" class="btn-search " title="查询">&nbsp;</a>
                    <td><a class="btns" id="searchReset" resetUrl="{{url('admin/douban/comments')}}"><span>重置</span></a></td>
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
                    <th class="align-center">影视名称</th>
                    <th class="align-center">所属分类</th>
                    <th class="align-center">评论人</th>
                    <th class="align-center">更新时间</th>
                    <th class="align-center">添加时间</th>
                    <th class="align-center">操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($list as $value)
                    <tr class="hover" style="background: rgb(255, 255, 255);">
                        <td class="align-center"><input name="ids[]" type="checkbox" value="{{$value->id}}" class="checkItem"></td>
                        <td class="align-center">{{$loop->index+1}}</td>
                        <td class="align-center">{{$value->movie->ch_title}}</td>
                        <td class="align-center">{{$value->movie->category->title}}</td>
                        <td class="align-center">{{$value->user->name}}</td>
                        <td class="align-center">{{$value->updated_at}}</td>
                        <td class="align-center">{{$value->created_at}}</td>

                        <td class="align-center">
                            <a href="{{url('admin/douban/comments/detail?id=')}}{{$value->id}}">详情</a> |
                            <a href="JavaScript:void(0)" deleteId="{{$value['id']}}" deleteUrl="{{url('admin/douban/comments/del')}}" class="delete">删除</a></td>
                    </tr>

                @empty
                    <tr class="hover">
                        <td colspan="8" class="align-center">没有数据</td>

                    </tr>
                @endforelse

                </tbody>
                <tfoot class="tfoot">
                <tr>
                    <td class="align-center"><input type="checkbox" class="checkAll" name="chkVal"></td>

                    <td colspan="16"><label for="checkallBottom">全选</label>&nbsp;&nbsp;
                        <a href="JavaScript:void(0);" class="btn delAll" deleteUrl="{{url('admin/douban/comments/del')}}"><span>删除</span></a>

                        <div class="pagination">
                          {{$list->links()}}
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
@endsection

