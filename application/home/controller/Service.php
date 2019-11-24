<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/23
 * Time: 16:00
 */

namespace app\home\controller;


use app\admin\model\Drive;
use app\home\model\DriverLicense;
use think\Model;

class Service extends Base
{

    public function drive()
    {
        $param=$this->request->param();
        if(request()->isPost()) {
            $param['member_id']=session('member_id');
            $param['order_number']= date('Ymd'). session('member_id') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $model=new Drive();
            return $model->add($param);
        }
        return $this->assign('car_info',[$param['car_id'],$param['car']])->fetch();
    }

    /**
     * 获取驾驶证
     */
    public function driver(){
        $driver=new DriverLicense();
        $d=$driver->getDriverByMemberId(session('member_id'));
        if ($d)
            return ['code'=>1,'data'=>$d,'msg'=>'ok'];

        return ['code'=>0,'data'=>[],'msg'=>'没有驾驶证'];
    }

    public function add(){
        if(request()->isPost()) {
            $param = input('post.');
            $param['member_id']=session('member_id');
            if (isset($param['file']))
                unset($param['file']);

            $model=new DriverLicense();
            $res = $model->addDriverLicense($param);
            return json($res);
        }
        return $this->fetch();
    }

    public function upload(){
        $file = request()->file('file');
        if($file){
            $info = $file->validate(['size'=>15678,'ext'=>'jpg,png,gif'])
                ->rule('uniqid')
                ->move('../public/uploads/driver');
            if($info){
                $path='/uploads/driver/'.$info->getSaveName();
                return ['code'=>1,'data'=>['src'=>$path],'msg'=>'上传成功'];
            }else{
                // 上传失败获取错误信息
                return ['code'=>0,'data'=>'','msg'=>'上传失败,'.$file->getError()];
            }
        }
        return ['code'=>0,'data'=>'','msg'=>'请选择文件'];
    }

    public function ride()
    {
        return $this->fetch();
    }

}