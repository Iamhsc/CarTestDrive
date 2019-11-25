<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/17
 * Time: 14:04
 */

namespace app\admin\model;


use think\Model;

class Car extends Model
{
    protected $table="ctd_car_model";
    protected $autoWriteTimestamp = true;

    /**
     * @param $limit
     * @param $where
     * @return array
     * @throws \think\exception\DbException
     */
    public function getCarList($limit, $where){
        $ls=self::alias('m')
            ->join('car_brand b','b.brand_id = m.car_brand_id','RIGHT')
            ->where($where)
            ->field('m.*,b.brand_id,b.brand_name')
            ->paginate($limit);
        return modelReMsg(0,$ls,'ok');
    }

    /**
     * 根据id获取车辆信息
     * @param $id
     * @return array|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCarById($id){
        return self::alias('m')
            ->join('car_brand b','b.brand_id = m.car_brand_id','RIGHT')
            ->where('m.car_model_id',$id)
            ->field('m.*,b.brand_id,b.brand_name')->find();
    }

    /**
     * 获取某品牌汽车数量
     * @param $brand_id
     * @return float|string
     */
    public function getCountByBrandId($brand_id){
        return self::where('car_brand_id',$brand_id)->count();
    }

    /**
     * 添加车辆
     * @param $data
     * @return array
     */
    public function addCar($data){
        $count=self::where('car_model_name',$data['car_model_name'])->count();
        if ($count>0)
            return modelReMsg(-1, '', '该车辆已存在');
        $id=self::save($data);
        if ($id)
            return modelReMsg(0, '', '添加车辆成功');
        return modelReMsg(-1, '', '添加车辆失败');
    }

    /**
     * 编辑车辆
     * @param $data
     * @return array
     */
    public function editCar($data){
        $edit = self::save($data,['car_model_id'=>$data['car_model_id']]);
        if ($edit)
            return modelReMsg(0, '', '修改成功');
        return modelReMsg(-1, '', '修改失败');
    }

    public function setStatus($id){
        return self::update(['status'=>1],['car_model_id'=>$id]);
    }

    /**
     * 删除车辆
     * @param $id
     * @return bool
     */
    public function delCar($id){
        return self::save(['is_del'  => 1],['car_model_id' => $id]);
    }
}