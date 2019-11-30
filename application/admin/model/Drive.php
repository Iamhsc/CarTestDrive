<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/18
 * Time: 17:31
 */

namespace app\admin\model;


use think\Model;

class Drive extends Model
{
    protected $table='ctd_drive';

    /**
     * 获取车辆开始使用时间格式化
     * @param $value
     * @return false|string
     */
    public function getBeginTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
    }

    /**
     * 获取车辆使用结束时间格式化
     * @param $value
     * @return false|string
     */
    public function getEndTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
    }

    /**
     * 设置车辆开始使用时间格式化
     * @param $value
     * @return false|int
     */
    public function setBeginTimeAttr($value){
        return strtotime($value);
    }

    /**
     * 设置辆使用结束时间格式化
     * @param $val
     * @return false|int
     */
    public function setEndTimeAttr($val){
        return strtotime($val);
    }

    /**
     * 获取试驾
     * @param array $limit
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public function getDriveOrderList($limit=[], $where=[]){
        $ls=self::alias('d')
            ->join('car_model cm','cm.car_model_id=d.car_id','RIGHT')
            ->join('member m','m.member_id=d.member_id','RIGHT')
            ->join('car_brand cb','cm.car_brand_id = cb.brand_id','RIGHT')
            ->where('d.is_del',0)
            ->where($where)
            ->field('d.drive_id,d.order_number,m.real_name,cb.brand_name,cm.car_model_id,cm.car_model_name,d.driver_license,d.begin_time,d.use_type,d.status')
            ->paginate($limit);
        return modelReMsg(0,$ls,'ok');
    }

    /**
     * 添加试驾试乘
     * @param $data
     * @return array
     */
    public function add($data){
        $id=self::save($data);
        if ($id)
            return modelReMsg(1, '', '成功');
        return modelReMsg(0, '', '失败');
    }

    /**
     * 删除试驾试乘（就是删除订单）
     * @param $id
     * @return bool
     */
    public function delOrder($id){
        return self::save(['is_del'  => 1],['drive_id' => $id]);
    }
}