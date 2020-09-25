
//自定义radio样式
$(document).ready(function () {
    $(".cb-enable").click(function () {
        var parent = $(this).parents('.onoff');
        $('.cb-disable', parent).removeClass('selected');
        $(this).addClass('selected');
        $('.checkbox', parent).attr('checked', true);
    });
    $(".cb-disable").click(function () {
        var parent = $(this).parents('.onoff');
        $('.cb-enable', parent).removeClass('selected');
        $(this).addClass('selected');
        $('.checkbox', parent).attr('checked', false);
    });
});

$(function () {
    // 显示隐藏预览图 start
    $('.show_image').hover(
        function () {
            $(this).next().css('display', 'block');
        },
        function () {
            $(this).next().css('display', 'none');
        }
    );

    //全选、反选
    $('.checkAll').click(function () {

        $('.checkAll').prop('checked',$(this).prop('checked'));

        $('.checkItem').each(function () {
            $(this).prop('checked', $('.checkAll').prop('checked'));
        });

    });

    // 表格鼠标悬停变色 start
    $("tbody .hover").hover(
        function () {
            $(this).css({background: "#FBFBFB"});
        },
        function () {
            $(this).css({background: "#FFF"});
        });

    // 可编辑列（input）变色
    $('.editable').hover(
        function () {
            $(this).removeClass('editable').addClass('editable2');
        },
        function () {
            $(this).removeClass('editable2').addClass('editable');
        }
    );

    // 提示操作 展开与隐藏
    $("#prompt tr:odd").addClass("odd");
    $("#prompt tr:not(.odd)").hide();
    $("#prompt tr:first-child").show();

    $("#prompt tr.odd").click(function () {
        $(this).next("tr").toggle();
        $(this).find(".title").toggleClass("ac");
        $(this).find(".arrow").toggleClass("up");

    });

    // 可编辑列（area）变色
    $('.editable-tarea').hover(
        function () {
            $(this).removeClass('editable-tarea').addClass('editable-tarea2');
        },
        function () {
            $(this).removeClass('editable-tarea2').addClass('editable-tarea');
        }
    );

    //表单提交
    $('#submitBtn').on('click', function () {
        $('#form').submit();
    });

    //搜索提交
    $('#searchSubmit').on('click', function () {
        $('#formSearch').submit();
    });

    //重置
    $('#searchReset').click(function(){
        var url = $(this).attr('resetUrl');
        location.href = url;
    });

    //删除单个
    $('.delete').click(function () {
        var that = $(this);
        layer.confirm("您确定要删除吗？", {
            btn: ["确定", "取消"]
        }, function (index) {
            layer.close(index);
            var ids=[];
            var delId = that.attr('deleteId');
            var url = that.attr('deleteUrl');
            var token = $('meta[name="csrf-token"]').attr('content');
            var _method = "delete";
            ids.push(delId);

            $.ajax({
                type:'POST',
                url:url,
                dataType:'json',
                data:{ids:ids, _token: token, _method: _method},
                success:function(data){
                //console.log(data);return false;
                    if (data.status == 200) {
                        layer.msg(data.msg, {icon: 6, time: 3000});
                    } else {
                        layer.msg(data.msg, {icon: 5, time: 3000});
                    }
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                },
                error:function(error){
                    layer.msg(error.responseJSON.errors.ids[0], {icon: 5, time: 3000});

                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }
            });
        }, function () {
            location.reload();
        });
    });

    //删除多个
    $('.delAll').click(function(){
        var that = $(this);

        layer.confirm("您确定要删除吗？", {
            btn: ["确定","取消"] //按钮
        }, function(){
            var ids=[];
            var url=that.attr('deleteUrl');
            var token=$('meta[name="csrf-token"]').attr('content');
            var _method ="delete";

            $('.checkItem').each(function(){
                if($(this).prop('checked')){
                    ids.push($(this).val());
                };
            });

            $.ajax({
                type:'POST',
                url:url,
                dataType:'json',
                data:{ids:ids, _token: token, _method: _method},
                success:function(data){
                    // console.log(data);return false;
                    if (data.status == 200) {
                        layer.msg(data.msg, {icon: 6, time: 3000});
                    } else {
                        layer.msg(data.msg, {icon: 5, time: 3000});
                    }

                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                },
                error:function(error){
                    // console.log(error);return false;
                    layer.msg(error.responseJSON.errors.ids[0], {icon: 5, time: 3000});

                    setTimeout(function(){
                        location.reload();
                    }, 1000);

                }
            });

        }, function(){
            location.reload();
        });
    });
});


