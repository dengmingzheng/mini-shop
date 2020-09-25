@extends('system.layout.base')
@section('content')
    <div class="header_line">
        <h3>评论管理</h3>
        <ul class="tab-base">
            <li><a href="{{url('admin/douban/comments')}}"><span>评论列表</span></a></li>
            <li><a class="current"><span>评论详情</span></a></li>
        </ul>
    </div>

    <div class="content-group">
        <table class="table tb-type2">
            <tbody>

            <tr>
                <td style="width:50px;"><label class="">影视名称:</label></td>
                <td class="vatop rowform">{{$detail['movie']['ch_title'] ? $detail['movie']['ch_title'] : $detail['movie']['zh_title']}}</td>
            </tr>

            <tr>
                <td class="wp14"><label class="">所属分类:</label></td>
                <td class="vatop rowform">{{$detail['movie']['category']['title']}}</td>
            </tr>
            <tr>
                <td class="wp14"><label class="">评论人:</label></td>
                <td class="vatop rowform">{{$detail['user']['name']}}</td>
            </tr>
            <tr>
                <td class="wp14"><label class="">评分:</label></td>
                <td class="vatop rowform">{{$detail['rate']}}</td>
            </tr>

            <tr>
                <td class="wp14"><label class="">评论内容:</label></td>
                <td class="vatop rowform">{{$detail['content']}}</td>
            </tr>

            <tr>
                <td class="wp14"><label class="">评论时间:</label></td>
                <td class="vatop rowform">{{$detail['created_at']}}</td>
            </tr>

            </tbody>
            <tfoot>
            <tr class="tfoot">
                <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="return"><span>返回</span></a></td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('script')
    <script>

        $(function(){
            $('#return').on('click', function(){
                history.go(-1);}
            )
        });
    </script>
@endsection