<?php /*a:1:{s:68:"/vagrant/phpwebsite/CarTestDrive/application/admin/view/car/add.html";i:1573978613;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加车辆</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
</head>
<body>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body">
                    <form class="layui-form" action="" lay-filter="component-form-element">
                        <div class="layui-row layui-col-space10 layui-form-item">
                            <div class="layui-col-lg6">
                                <label class="layui-form-label">品牌：</label>
                                <div class="layui-input-block">
                                    <select name="car_brand_id" lay-verify="required">
                                        <option value="">请选择一个品牌</option>
                                        <?php if(is_array($brand) || $brand instanceof \think\Collection || $brand instanceof \think\Paginator): if( count($brand)==0 ) : echo "" ;else: foreach($brand as $key=>$vo): ?>
                                        <option value="<?php echo htmlentities($vo['brand_id']); ?>"><?php echo htmlentities($vo['brand_name']); ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-col-lg6">
                                <label class="layui-form-label">汽车型号：</label>
                                <div class="layui-input-block">
                                    <input type="text" name="car_model_name" lay-verify="required" placeholder="请输入车牌号" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-col-lg6">
                                <label class="layui-form-label">车牌号：</label>
                                <div class="layui-input-block">
                                    <input type="text" name="car_number" lay-verify="required" placeholder="请输入车牌号" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-col-lg6">
                                <label class="layui-form-label">已使用：</label>
                                <div class="layui-input-block">
                                    <input type="text" name="car_age" lay-verify="required" placeholder="已使用的时间 以年为单位" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" lay-submit lay-filter="component-form-element">立即提交</button>
                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/static/layui/layui.js"></script>
<script src="/static/common/js/jquery.min.js"></script>
<script src="/static/common/js/layTool.js"></script>

<script>
    layui.config({
        base: '/static/admin/'
    }).use(['form'], function(){
        var $ = layui.$
            ,form = layui.form;
        form.on('submit(component-form-element)', function(data){
            $.post("<?php echo url('car/add'); ?>", data.field, function (res) {
                if(0 == res.code) {
                    layer.msg(res.msg);
                    setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                        window.parent.renderTable();
                    }, 200);
                } else {
                    layTool.alert(res.msg, '友情提示', 2);
                }
            }, 'json');
            return false;
        });
    });
</script>
</body>
</html>