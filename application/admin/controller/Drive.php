<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/18
 * Time: 15:10
 */

namespace app\admin\controller;

/**
 * 试驾试乘控制器
 * Class Drive
 * @package app\admin\controller
 */
class Drive extends Base
{
    /**
     * 获取试驾
     * @return mixed|\think\response\Json
     * @throws \think\exception\DbException
     */
    public function index(){
        if (request()->isAjax()) {
            $limit = input('param.limit');
            $real_name = input('param.real_name');

            $where=[];
            if (!empty($real_name)) {
                $where[] = ['m.real_name', 'like', '%'.$real_name.'%'];
            }
            $model=new \app\admin\model\Drive();
            $ls=$model->getDriveOrderList($limit,$where);
            if ($ls['code']===0)
                return json(['code' => 0, 'msg' => 'ok', 'count' => $ls['data']->total(), 'data' => $ls['data']->all()]);
            else
                return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => []]);
        }
        return $this->fetch();
    }

    /**
     * 删除试驾试乘
     * @return \think\response\Json
     */
    public function del(){
        $param=$this->request->param();
        $model=new \app\admin\model\Drive();
        $del=$model->delOrder($param['id']);
        if($del)
            return json(['code' => 0, 'msg' => '删了成功', 'count' => 0, 'data' => []]);
        return json(['code' => -1, 'msg' => '删了失败', 'count' => 0, 'data' => []]);
    }
}