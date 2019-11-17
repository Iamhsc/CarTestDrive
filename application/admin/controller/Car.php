<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/17
 * Time: 14:02
 */

namespace app\admin\controller;


use app\admin\validate\CarValidate;

class Car extends Base
{
    /**
     * 获取汽车列表
     * @return mixed|\think\response\Json
     * @throws \think\exception\DbException
     */
    public function index(){
        if (request()->isAjax()) {
            $limit = input('param.limit');
            $car_model_name = input('param.car_model_name');

            $where=[];
            $where[] = ['m.is_del','=',0];
            if (!empty($car_model_name)) {
                $where[] = ['m.car_model_name', 'like', '%'.$car_model_name.'%'];
            }
            $model=new \app\admin\model\Car();
            $ls=$model->getCarList($limit,$where);
            if ($ls['code']===0)
                return json(['code' => 0, 'msg' => 'ok', 'count' => $ls['data']->total(), 'data' => $ls['data']->all()]);
            else
                return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => []]);
        }
        return $this->fetch();
    }

    /**
     * 添加车辆
     * @return mixed|\think\response\Json
     * @throws \think\exception\DbException
     */
    public function add(){
        if(request()->isPost()) {
            $param = input('post.');
            $model=new \app\admin\model\Car();
            $res = $model->addCar($param);
            return json($res);
        }
        $b=new \app\admin\model\CarBrand();
        $brand=$b->getCarBrandList();
        return $this->assign('brand',$brand['data'])->fetch();
    }

    /**
     * 删除车辆
     * @return \think\response\Json
     */
    public function del(){
        $param=$this->request->param();
        $model=new \app\admin\model\Car();
        $del=$model->delCar($param['id']);
        if($del)
            return json(['code' => 0, 'msg' => '删了成功', 'count' => 0, 'data' => []]);
        return json(['code' => -1, 'msg' => '删了失败', 'count' => 0, 'data' => []]);
    }

    /**
     * 编辑车辆
     * @return array|mixed|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit(){
        $model=new \app\admin\model\Car();
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new CarValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $res = $model->editCar($param);
            return json($res);
        }
        $car=$model->getCarById(input('param.id'));
        $brand=new \app\admin\model\CarBrand();
        $b=$brand->getCarBrandList();
        return $this->assign(['car'=>$car,'brand'=>$b['data']])->fetch();
    }
}