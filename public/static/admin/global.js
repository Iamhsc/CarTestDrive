layui.define(['element','form'], function(exports) {
    var $ = layui.jquery,element = layui.element,
        layer = layui.layer,
        form = layui.form;

        /**
     * 通用状态设置开关
     * @attr data-href 请求地址
     * @attr confirm 确认提示
     */
    form.on('switch(switchStatus)', function(data) {
        let that = $(this), status = 0, func = function() {
            $.get(that.attr('data-href'), {val:status}, function(res) {
                layer.msg(res.msg);
                if (res.code == 0) {
                    that.trigger('click');
                    form.render('checkbox');
                }
            });
        };
        if (typeof(that.attr('data-href')) == 'undefined') {
            layer.msg('请设置data-href参数');
            return false;
        }
        if (this.checked) {
            status = 1;
        }

        if (typeof(that.attr('confirm')) == 'undefined') {
            func();
        } else {
            layer.confirm(that.attr('confirm') || '你确定要执行操作吗？', {title:false, closeBtn:0}, function(index){
                func();
            }, function() {
                that.trigger('click');
                form.render('checkbox');
            });
        }
    });
    exports('global', {});
});