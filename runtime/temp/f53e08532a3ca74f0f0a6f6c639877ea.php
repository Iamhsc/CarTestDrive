<?php /*a:1:{s:75:"/vagrant/phpwebsite/CarTestDrive/application/admin/view/car_type/index.html";i:1573910089;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>车辆类型管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">搜索</label>
                    <div class="layui-input-block">
                        <input type="text" name="type_name" placeholder="请输入车辆类型" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="LAY-car-type-back-search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-admin" data-type="add"><i class="layui-icon">&#xe654;</i> 添加
                </button>
            </div>
            <table id="LAY-car-type-table" lay-filter="LAY-car-type-table"></table>
            <script type="text/html" id="table-seller-car-type">
                <?php if((buttonAuth('car_type/edit'))): ?>
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                        class="layui-icon layui-icon-edit"></i>编辑</a>
                <?php endif; if((buttonAuth('car_type/del'))): ?>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                        class="layui-icon layui-icon-delete"></i>删除</a>
                <?php endif; ?>
            </script>
        </div>
    </div>
</div>

<script src="/static/layui/layui.js"></script>
<script src="/static/common/js/layTool.js"></script>
<script src="/static/common/js/jquery.min.js"></script>

<script>
    layui.config({
        base: '/static/admin/'
    }).use(['table', 'global'], function () {
        var $ = layui.$
            , form = layui.form
            , table = layui.table;
        var active = {
            add: function () {
                layTool.open("<?php echo url('car_type/add'); ?>", "添加车辆类型", '50%', '50%');
            }
        };

        $('.layui-btn.layuiadmin-btn-admin').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

        // 监听搜索
        form.on('submit(LAY-car-type-back-search)', function (data) {
            var field = data.field;
            // 执行重载
            table.reload('LAY-car-type-table', {
                where: field
            });
        });
    });

    renderTable();

    // 渲染表格
    function renderTable() {
        layTool.table("#LAY-car-type-table", "/admin/car_type/index", [
            [{
                field: "type_id",
                title: "类型ID"
            }, {
                field: "type_name",
                title: "类型名",
            }, {
                field: "create_time",
                title: "添加时间",
            }, {
                field: "update_time",
                title: "更新时间",
            }, {
                title: "操作",
                align: "center",
                width: 150,
                fixed: "right",
                toolbar: "#table-seller-car-type"
            }]
        ]);

        layui.use(['table', 'layer'], function () {
            let layer = layui.layer;
            let table = layui.table;

            table.on("tool(LAY-car-type-table)",
                function (e) {
                    if ("del" === e.event) {

                        layer.ready(function () {
                            var index = layer.confirm('您确定要删除该类型？', {
                                title: '友情提示',
                                icon: 3,
                                btn: ['确定', '取消']
                            }, function () {
                                $.getJSON('<?php echo url("car_type/del"); ?>', {id: e.data.type_id}, function (res) {
                                    if (0 == res.code) {
                                        layer.msg(res.msg);
                                        setTimeout(function () {
                                            renderTable();
                                        }, 300);
                                    } else {
                                        layer.alert(res.msg);
                                    }
                                });
                            }, function () {

                            });
                        });
                    } else if ("edit" === e.event) {
                        layTool.open("/admin/car_type/edit/id/" + e.data.type_id, "编辑", '50%', '50%');
                    }
                });
        });
    }
</script>
</body>
</html>
