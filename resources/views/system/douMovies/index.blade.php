@extends('system.layout.base')
@section('content')
    <div class="header_line">
        <h3>豆瓣管理</h3>
        <ul class="tab-base">
            <li><a class="current"><span>影视列表</span></a></li>
            <li><a href="{{url('admin/douban/movies/create')}}"><span>添加影视</span></a></li></ul>
    </div>


    <div class="content-group">

        <form method="get" id="formSearch">
            <table class="tb-type1 noborder search">
                <tbody>
                <tr>
                    <!-- 查询条件 -->
                    <th><label for="title">中文名称:</label></th>
                    <td><input type="text" value="{{request()->input('title')}}" name="title" class="txt"></td>

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

                    <th><label for="region_id">制片国家:</label></th>
                    <td>
                        <select id="region_id" name="region_id" class="valid">
                            <option value="">--请选择--</option>
                            @if(!empty($regionList))
                                @foreach($regionList as $val)
                                    <option value="{{$val['id']}}" @if(request()->input('region_id') == $val['id']) selected="selected" @endif>{{$val['title']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>

                    <th><label for="title">年份:</label></th>
                    <td><input type="text" value="{{request()->input('year')}}" name="year" class="txt" id="chooseYear" autocomplete="off"></td>

                    <td><a href="javascript:void(0);" id="searchSubmit" class="btn-search " title="查询">&nbsp;</a>
                    <td><a class="btns" id="searchReset" resetUrl="{{url('admin/douban/movies')}}"><span>重置</span></a></td>
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
                    <th class="align-center">中文名称</th>
                    <th class="align-center">封面</th>
                    <th class="align-center">分类名称</th>
                    <th class="align-center">评分</th>
                    <th class="align-center">评价人数</th>
                    <th class="align-center">评论人数</th>
                    <th class="align-center">制片国家</th>
                    <th class="align-center">时长</th>
                    <th class="align-center">发行年份</th>
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
                        <td class="align-center">{{$value->ch_title ? $value->ch_title : $value->zh_title}}</td>
                        <td class="align-center"><img src="{{$value->image_path}}" style="width: 50px;height: 50px" /></td>
                        <td class="align-center">{{$value->category ? $value->category->title : '' }}</td>
                        <td class="align-center">{{$value->rate}}</td>
                        <td class="align-center">{{$value->rate_num}}</td>
                        <td class="align-center">{{$value->comment_num}}</td>
                        <td class="align-center">{{$value->region_name}}</td>
                        <td class="align-center">{{$value->length_time}}</td>
                        <td class="align-center">{{$value->year}}</td>
                        <td class="align-center">{{$value->updated_at}}</td>
                        <td class="align-center">{{$value->created_at}}</td>

                        <td class="align-center">
                            <a href="{{url('admin/douban/movies/edit?id=')}}{{$value->id}}">编辑</a> |
                            <a href="JavaScript:void(0)" deleteId="{{$value['id']}}" deleteUrl="{{url('admin/douban/movies/del')}}" class="delete">删除</a></td>
                    </tr>

                @empty
                    <tr class="hover">
                        <td colspan="14" class="align-center">没有数据</td>

                    </tr>
                @endforelse

                </tbody>
                <tfoot class="tfoot">
                <tr>
                    <td class="align-center"><input type="checkbox" class="checkAll" name="chkVal"></td>

                    <td colspan="16"><label for="checkallBottom">全选</label>&nbsp;&nbsp;
                        <a href="JavaScript:void(0);" class="btn delAll" deleteUrl="{{url('admin/douban/movies/del')}}"><span>删除</span></a>

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

@section('script')
    <script src="/system/js/laydate/laydate.js"></script>
    <script>
        laydate.render({
            elem: '#chooseYear', //指定元素
            type: 'year'
        });
    </script>
@endsection

