<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/16
 * Time: 20:21
 */

namespace app\admin\controller;


use app\admin\validate\CarTypeValidate;

class CarType extends Base
{
    /**
     * 获取车辆类型列表
     * @return mixed|\think\response\Json
     * @throws \think\exception\DbException
     */
    public function index(){
        if (request()->isAjax()) {
            $limit = input('param.limit');
            $type_name = input('param.type_name');

            $where=[];
            $where[] = ['is_del','=',0];
            if (!empty($type_name)) {
                $where[] = ['type_name', 'like', '%'.$type_name.'%'];
            }
            $model=new \app\admin\model\CarType();
            $ls=$model->getCarTypeList($limit,$where);
            if ($ls['code']===0)
                return json(['code' => 0, 'msg' => 'ok', 'count' => $ls['data']->total(), 'data' => $ls['data']->all()]);
            else
                return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => []]);
        }
        return $this->fetch();
    }

    /**
     * 添加车辆类型
     * @return mixed|\think\response\Json
     */
    public function add(){
        if(request()->isPost()) {
            $param = input('post.');
            $model=new \app\admin\model\CarType();
            $res = $model->addCarType($param);
            return json($res);
        }
        return $this->fetch();
    }

    /**
     * 编辑车辆类型
     * @return array|mixed|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public  function edit(){
        $model=new \app\admin\model\CarType();
        $type=$model->getCarTypeById(input('param.id'));
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new CarTypeValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $res = $model->editCarType($param);
            return json($res);
        }
        return $this->assign('t',$type)->fetch();
    }

    /**
     * 删除车辆类型
     * @return \think\response\Json
     */
    public function del(){
        $param=$this->request->param();
        $model=new \app\admin\model\CarType();
        $del=$model->delCarType($param['id']);
        if($del)
            return json(['code' => 0, 'msg' => '删了成功', 'count' => 0, 'data' => []]);
        return json(['code' => -1, 'msg' => '删了失败', 'count' => 0, 'data' => []]);
    }
}