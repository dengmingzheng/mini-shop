@extends('system.layout.base')

@section('content')
    <div class="header_line">
        <h3>系统管理</h3>
        <ul class="tab-base">
            <li><a class="current"><span>操作日志</span></a></li>
        </ul>
    </div>


    <div class="content-group">
        <form method="get" name="formSearch" id="formSearch" action="{{url('admin/logs')}}">
            <table class="tb-type1 noborder search">
                <tbody>
                <tr>
                    <!-- 查询条件 -->
                    <th><label for="admin_name">操作人</label></th>
                    <td><input type="text" value="{{request()->input('username')}}" name="username" class="txt"></td>

                    <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="查询">&nbsp;</a></td>
                    <td><a class="btns" id="clear"><span>清空</span></a></td>
                </tr>
                </tbody>
            </table>
        </form>

        <form method="post" id="form" action="">

            <table class="table tb-type2 nobdb">
                <thead>
                <tr class="thead">
                    <th class="align-center"><input type="checkbox" class="checkAll"  name="chkVal"></th>
                    <th>序号</th>
                    <th class="align-center">操作人</th>
                    <th class="align-center">内容</th>
                    <th class="align-center">时间</th>
                </tr>
                </thead>
                <tbody>
                @forelse($list as $value)
                    <tr class="hover" style="background: rgb(255, 255, 255);">
                        <td class="align-center"><input name="ids[]" type="checkbox" value="{{$value['id']}}" class="checkItem"></td>
                        <td class="align-center">{{$loop->index+1}}</td>
                        <td class="align-center">{{$value->username ? $value->username : ''}}</td>
                        <td class="align-center">{{$value->content}}</td>
                        <td class="align-center">{{$value->created_at}}</td>
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
                        <a href="JavaScript:void(0);" class="btn"><span>删除</span></a>

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
