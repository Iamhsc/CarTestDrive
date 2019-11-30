<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/24
 * Time: 13:53
 */

namespace app\home\model;


use think\Model;

class DriverLicense extends Model
{
    protected $table='ctd_driver_license';

    /**
     * @param $member_id
     * @return array|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDriverByMemberId($member_id){
        return self::where('member_id',$member_id)->find();
    }

    /**
     * 添加驾驶证
     * @param $data
     * @return array
     */
    public function addDriverLicense($data){
        $id=self::save($data);
        if ($id)
            return modelReMsg(1, '', '添加驾驶证成功');
        return modelReMsg(0, '', '添加驾驶证失败');
    }
}