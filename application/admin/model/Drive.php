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

    //开始使用时间格式化
    public function getBeginTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
    }

    //使用结束时间格式化
    public function getEndTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
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
            ->field('d.drive_id,d.order_number,m.real_name,cb.brand_name,cm.car_model_name,d.begin_time,d.use_type,d.status')
            ->paginate($limit);
        return modelReMsg(0,$ls,'ok');
    }

    public function delOrder($id){
        return self::save(['is_del'  => 1],['drive_id' => $id]);
    }
}