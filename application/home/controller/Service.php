<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/23
 * Time: 16:00
 */

namespace app\home\controller;


use app\admin\model\Car;
use app\admin\model\Drive;
use app\home\model\DriverLicense;

class Service extends Base
{

    /**
     * 用车
     * @return array|mixed
     */
    public function drive()
    {
        $param = $this->request->param();
        if (request()->isPost()) {
            $uid = $this->uid();
            $param['member_id'] = $uid;
            $param['order_number'] = date('Ymd') . $uid . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

            $model = new Drive();
            $car = new Car();
            $car->setStatus($param['car_id']);
            return $model->add($param);
        }
        return $this->assign('car_info', [$param['car_id'], $param['car']])->fetch();
    }

    /**
     * 还车
     */
    public function recar(){
        if (request()->isPost()) {
            $param = $this->request->param();
            $d=Drive::update(['status'=>2,'end_time'=>time()],['drive_id'=>$param['drive_id']]);
            $c=Car::update(['status'=>0],['car_model_id'=>$param['car_id']]);
            if ($d&&$c)
                return ['code'=>1,'msg'=>'success'];
            return ['code'=>0,'msg'=>'fail'];
        }
    }

    /**
     * 获取驾驶证
     */
    public function driver()
    {
        $driver = new DriverLicense();
        $d = $driver->getDriverByMemberId($this->uid());
        if ($d)
            return ['code' => 1, 'data' => $d, 'msg' => 'ok'];

        return ['code' => 0, 'data' => [], 'msg' => '没有驾驶证'];
    }

    /**
     * 添加驾驶证
     * @return mixed|\think\response\Json
     */
    public function add()
    {
        if (request()->isPost()) {
            $param = input('post.');
            $param['member_id'] = $this->uid();
            if (isset($param['file']))
                unset($param['file']);

            $model = new DriverLicense();
            $res = $model->addDriverLicense($param);
            return json($res);
        }
        return $this->fetch();
    }

    public function upload()
    {
        $file = request()->file('file');
        if ($file) {
            $info = $file->validate(['size' => 15678, 'ext' => 'jpg,png,gif'])
                ->rule('uniqid')
                ->move('../public/uploads/driver');
            if ($info) {
                $path = '/uploads/driver/' . $info->getSaveName();
                return ['code' => 1, 'data' => ['src' => $path], 'msg' => '上传成功'];
            } else {
                // 上传失败获取错误信息
                return ['code' => 0, 'data' => '', 'msg' => '上传失败,' . $file->getError()];
            }
        }
        return ['code' => 0, 'data' => '', 'msg' => '请选择文件'];
    }
}