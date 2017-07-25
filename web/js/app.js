$(function() {
    // 打开新页面
    $('.open_win').click(function() {
        var url = $(this).attr('data-url');
        var title = $(this).attr('data-title');
        var height = $(this).attr('data-height');
        var width = $(this).attr('data-width');
        if (typeof height == 'undefined') {
            height = '80%';
        }
        if (typeof width == 'undefined') {
            width = '90%';
        }

        layui.use('layer', function() {
            var layer = layui.layer;
            layer.open({
                type: 2,
                title: title,
                shadeClose: true,
                shade: 0.8,
                area: [width, height],
                content: url
            });
        });
    });

    // 控制时间筛选显示
    $('.custom_date').change(function() {
        var val = $(this).val();
        var node= $(this).attr('data-node');
        if (val == -1) {
            $(node).show().find('input').val('');
        } else {
            $(node).hide();
        }
    });
});

/**
 * post请求封装
 * @auatho: Gene
 * @param url
 * @param data
 * @param callback
 */
function post(url, data, callback) {
    var loading;
    data._csrf = window._csrf;
    layui.use('layer', function() {
        var layer = layui.layer;
        $.ajax({
            type : 'POST',
            url  : url,
            data : data,
            success : function(res) {
                layer.close(loading);
                if (res.code == 0) {
                    callback(res.data);
                } else {
                    APP.parent.APP.showMsg(res.msg, 'error');
                    callback(false);
                }
            },
            beforeSend : function() {
                loading = layer.load(0, {shade: false});
            },
            error: function() {
                layer.close(loading);
                callback(false);
            }
        });
    });
}


/**
 * 关闭当前窗口,刷新父窗口
 */
function reloadParent(millisec) {
    millisec = millisec>0 ? millisec : 1;
    setTimeout(function() {
        parent.window.location.reload();
    }, millisec);
}


// 时间选择插件
function showDate(th) {
    layui.use('laydate', function() {
        var laydate = layui.laydate;

        $(th).click(function() {
            laydate({
                elem: this
            });
        });
    });
}
