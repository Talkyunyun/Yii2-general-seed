/**
 * 顶级窗口对象
 * @author: Gene
 * @constructor
 */
function APP() {
    var self = this;
    this.name = '阿凡达物流管理系统';

    this.init();
}

// 初始化
APP.prototype.init = function() {

}

/**
 * 全局提示
 * @type {Core}
 */
APP.prototype.showMsg = function() {
    var msg = arguments[0] ? arguments[0] : '操作成功!';
    var type= arguments[1] ? arguments[1] : 'success';
    var position = arguments[2] ? arguments[2] : 'toast-top-center';

    try {
        // 参数配置
        toastr.options = {
            "closeButton": true,
            "debug": true,
            "progressBar": true,
            "positionClass": position,
            "timeOut": "3000",
        }

        switch (type) {
            case 'info':
                toastr.info(msg);
                break;
            case 'warning':
                toastr.warning(msg);
                break;
            case 'error':
                toastr.error(msg);
                break;
            default :
                toastr.success(msg);
        }
    } catch (err) {
        toastr.error('操作失败,参数错误');
    }
}


/**
 * 打开新的TAB页面
 */
APP.prototype.openNewTab = function() {
    var url = arguments[0];
    var title = arguments[1] ? arguments[1] : '新页面';
    $('#open_tab').html(title).attr('href', url).click();
}

/**
 * 打开新的页面
 * @author: Gene
 */
APP.prototype.openPage = function(param) {
    if (typeof param != 'object') {
        throw '参数必须是一个对象';
    }

    layer.open(param);
}

var APP = new APP();