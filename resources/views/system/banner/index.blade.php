@extends('system.layout.base')
@section('content')
    <div class="header_line">
        <h3>网站管理</h3>
        <ul class="tab-base">
            <li><a class="current"><span>Banner管理</span></a></li>
            <li><a href="{{url('admin/banners/create')}}"><span>添加Banner</span></a></li></ul>
    </div>


    <div class="content-group">
        <form method="get" name="formSearch" id="formSearch">

            <table class="tb-type1 noborder search">
                <tbody>
                <tr>
                    <!-- 查询条件 -->
                    <th><label for="title">名称:</label></th>
                    <td><input type="text" value="{{request()->input('name')}}" name="name" class="txt"></td>

                    <th><label for="title">位置:</label></th>
                    <td><input type="text" value="{{request()->input('position')}}" name="position" class="txt"></td>

                    <th><label for="title">状态:</label></th>
                    <td>
                        <select name="status">
                            <option value="">请选择</option>
                            <option value="0" @if(is_numeric(request()->input('status')) && request()->input('status') == 0 ) selected="selected" @endif>禁用</option>
                            <option value="1" @if(is_numeric(request()->input('status')) && request()->input('status') == 1 ) selected="selected" @endif>启用</option>
                        </select>
                    </td>

                    <td><a href="javascript:void(0);" id="searchSubmit" class="btn-search " title="查询">&nbsp;</a>
                    <td><a class="btns" id="searchReset" resetUrl="{{URL('admin/banners')}}"><span>重置</span></a></td>
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
                    <th class="align-center">Banner名称</th>
                    <th class="align-center">位置</th>
                    <th class="align-center">链接类型</th>
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
                        <td class="align-center">{{$value['name']}}</td>
                        <td class="align-center">{{$value['position']}}</td>
                        <td class="align-center">{{$value['open_type']}}</td>
                        <td class="align-center">{{$value['sort']}}</td>
                        <td class="align-center">{{$value['status'] ? '启用' : '禁用'}}</td>
                        <td class="align-center">{{$value['updated_at']}}</td>
                        <td class="align-center">{{$value['created_at']}}</td>

                        <td class="align-center">
                            <a href="{{url('admin/banners/edit?id=')}}{{$value['id']}}">编辑</a> |
                            <a href="JavaScript:void(0)" deleteId="{{$value['id']}}" deleteUrl="{{url('admin/banners/del')}}" class="delete">删除</a></td>
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
                        <a href="JavaScript:void(0);" class="btn delAll" deleteUrl="{{url('admin/banners/del')}}"><span>删除</span></a>

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

@section('script')
  <script>
      $(function(){
          //推荐
          $('.recommend').click(function () {
              var that = $(this);
              layer.confirm("您确定要推荐吗？", {
                  btn: ["确定", "取消"]
              }, function (index) {
                  layer.close(index);
                  var recommend_id = that.attr('recommend_id');
                  var recommend = that.attr('recommend');
                  var url = "{{url('admin/banners/recommend')}}";
                  var token = $('meta[name="csrf-token"]').attr('content');
                  var _method = "post";

                  $.post(url, {id: recommend_id,recommend:recommend, _token: token, _method: _method}, function (data) {

                      if (data.status == 200) {
                          layer.msg(data.msg, {icon: 6, time: 3000});
                      } else {
                          layer.msg(data.msg, {icon: 5, time: 30000});
                      }

                      location.reload();
                  });
              }, function () {
                  location.reload();
              });
          });
      });
  </script>
@endsection
