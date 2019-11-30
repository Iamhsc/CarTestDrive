<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/16
 * Time: 20:21
 */

namespace app\admin\controller;


use app\admin\validate\CarBrandValidate;

/**
 * 汽车品牌控制器
 * Class CarBrand
 * @package app\admin\controller
 */
class CarBrand extends Base
{
    /**
     * 获取车辆品牌列表
     * @return mixed|\think\response\Json
     * @throws \think\exception\DbException
     */
    public function index(){
        if (request()->isAjax()) {
            $limit = input('param.limit');
            $brand_name = input('param.brand_name');

            $where=[];
            if (!empty($brand_name)) {
                $where[] = ['brand_name', 'like', '%'.$brand_name.'%'];
            }
            $model=new \app\admin\model\CarBrand();
            $ls=$model->getCarBrandList($limit,$where);
            if ($ls['code']===0)
                return json(['code' => 0, 'msg' => 'ok', 'count' => $ls['data']->total(), 'data' => $ls['data']->all()]);
            else
                return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => []]);
        }
        return $this->fetch();
    }

    /**
     * 添加车辆品牌
     * @return mixed|\think\response\Json
     */
    public function add(){
        if(request()->isPost()) {
            $param = input('post.');
            $model=new \app\admin\model\CarBrand();
            $res = $model->addCarBrand($param);
            return json($res);
        }
        return $this->fetch();
    }

    /**
     * 编辑车辆品牌
     * @return array|mixed|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public  function edit(){
        $model=new \app\admin\model\CarBrand();
        $brand=$model->getCarBrandById(input('param.id'));
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new CarBrandValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $res = $model->editCarBrand($param);
            return json($res);
        }
        return $this->assign('t',$brand)->fetch();
    }

    /**
     * 删除车辆品牌
     * @return \think\response\Json
     */
    public function del(){
        $param=$this->request->param();
        $id=$param['id'];
        $car=new \app\admin\model\Car();
        if ($car->getCountByBrandId($id)>0)
            return json(['code' => -1, 'msg' => '必须先删除该品牌所有车辆', 'count' => 0, 'data' => []]);
        $model=new \app\admin\model\CarBrand();
        $del=$model->delCarBrand($id);
        if($del)
            return json(['code' => 0, 'msg' => '删了成功', 'count' => 0, 'data' => []]);
        return json(['code' => -1, 'msg' => '删了失败', 'count' => 0, 'data' => []]);
    }
}