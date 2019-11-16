<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/16
 * Time: 20:57
 */

namespace app\admin\model;


use think\Model;

class CarType extends Model
{   protected $table="ctd_car_type";
    protected $autoWriteTimestamp = true;

    /**
     * 获取所有车辆类型
     * @param $limit
     * @param $where
     * @return array
     * @throws \think\exception\DbException
     */
    function getCarTypeList($limit, $where){
        $ls=self::where($where)
            ->paginate($limit);
        return modelReMsg(0,$ls,'ok');
    }

    /**
     * 根据id获取车辆类型
     * @param $id
     * @return array|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getCarTypeById($id){
        return self::where('type_id',$id)->find();
    }

    /**
     * 添加车辆类型
     * @param $data
     * @return array
     */
    function addCarType($data){
        $count=self::where('type_name',$data['type_name'])->count();
        if ($count>0)
            return modelReMsg(-1, '', '该类型已存在');
        $id=self::save($data);
        if ($id)
            return modelReMsg(0, '', '添加类型成功');
        return modelReMsg(-1, '', '添加类型失败');
    }

    /**
     * 编辑车辆类型
     * @param $data
     * @return array
     */
    function editCarType($data){
        $edit = self::save($data,['type_id'=>$data['type_id']]);
        if ($edit)
            return modelReMsg(0, '', '修改成功');
        return modelReMsg(-1, '', '修改失败');
    }

    /**
     * 删除车辆类型
     * @param $id
     * @return bool
     */
    function delCarType($id){
        return self::save(['is_del'  => 1],['type_id' => $id]);
    }
}