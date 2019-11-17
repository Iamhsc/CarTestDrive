<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/16
 * Time: 20:57
 */

namespace app\admin\model;


use think\Model;

class CarBrand extends Model
{
    protected $table="ctd_car_brand";
    protected $autoWriteTimestamp = true;

    /**
     * 获取所有车辆品牌
     * @param $limit
     * @param $where
     * @return array
     * @throws \think\exception\DbException
     */
    function getCarBrandList($limit=[], $where=[]){
        $ls=self::where($where)->where('is_del',0)
            ->paginate($limit);
        return modelReMsg(0,$ls,'ok');
    }

    /**
     * 根据id获取车辆品牌
     * @param $id
     * @return array|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getCarBrandById($id){
        return self::where('brand_id',$id)->find();
    }

    /**
     * 添加车辆品牌
     * @param $data
     * @return array
     */
    function addCarBrand($data){
        $count=self::where('brand_name',$data['brand_name'])->count();
        if ($count>0)
            return modelReMsg(-1, '', '该品牌已存在');
        $id=self::save($data);
        if ($id)
            return modelReMsg(0, '', '添加品牌成功');
        return modelReMsg(-1, '', '添加品牌失败');
    }

    /**
     * 编辑车辆品牌
     * @param $data
     * @return array
     */
    function editCarBrand($data){
        $edit = self::save($data,['brand_id'=>$data['brand_id']]);
        if ($edit)
            return modelReMsg(0, '', '修改成功');
        return modelReMsg(-1, '', '修改失败');
    }

    /**
     * 删除车辆品牌
     * @param $id
     * @return bool
     */
    function delCarBrand($id){
        return self::save(['is_del'  => 1],['brand_id' => $id]);
    }
}