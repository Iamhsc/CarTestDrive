<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/18
 * Time: 21:18
 */

namespace app\home\controller;

use app\admin\validate\MemberValidate;
use think\Validate;

class Member extends Base
{
    public function index(){
        $model=new \app\admin\model\Member();
        $info=$model->getMemberById($this->uid());
        $limit=[10,1];
        $where=[];
        $where[] = ['m.member_id', '=', $this->uid()];
        $model=new \app\admin\model\Drive();
        $ls=$model->getDriveOrderList($limit,$where);
        $this->assign(['member_info'=>$info,'drive'=>$ls['data']]);
        return $this->fetch();
    }

    public function edit(){
        $m=new \app\admin\model\Member();
        $uid=$this->uid();
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new MemberValidate();
            if(!$validate->scene('edit')->check($param))
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];

            $param['member_id']=$uid;
            $res = $m->editMember($param);
            return json($res);
        }
        $member=$m->getMemberById($uid);
        return $this->assign('member',$member)->fetch();
    }


    public function upload(){
        $file = request()->file('file');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->validate(['size'=>15678,'ext'=>'jpg,png,gif'])
                ->rule('uniqid')
                ->move('../public/uploads/avatar');
            if($info){
                $path='/uploads/avatar/'.$info->getSaveName();
                $model=new \app\admin\model\Member();
                $res=$model->editMember(['avatar'=>$path,'member_id'=>$this->uid()]);
                // 成功上传后 获取上传信息
                if ($res['code']==0){
                    $avatar=session('member_info')['avatar'];
                    $avatar ? unlink('../public/'.$avatar):'';
                    usleep(100);//延迟100毫秒，等待删完在执行下一句
                    session('member_info.avatar',$path);
                    return ['code'=>1,'data'=>['src'=>$path],'msg'=>'上传成功'];}
                else
                    unlink('../public/'.$path);//没存到数据库就删除新上传的文件
            }else{
                // 上传失败获取错误信息
                return ['code'=>0,'data'=>'','msg'=>'上传失败,'.$file->getError()];
            }
            return ['code'=>0,'data'=>'','msg'=>'上传失败'];
        }
        return ['code'=>0,'data'=>'','msg'=>'请选择文件'];
    }

    /**
     * 修改密码
     * @return array|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function reSetPassword(){
        $m=new \app\admin\model\Member();
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new Validate([
                'nowpass|原密码'  => 'require',
                'pass|新密码' => 'require',
                'repass|确认密码'=>'require'
            ]);
            if (!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $uid=$this->uid();
            $info=$m->getMemberById($uid);
            if (!checkPassword($param['nowpass'],$info['password']))
                return ['code' => -1, 'data' => '', 'msg' => '原密码不正确'];

            if ($param['pass']!=$param['repass'])
                return ['code' => -1, 'data' => '', 'msg' => '两个新密码不相同'];

            $data=[];
            $data['member_id']=$uid;
            $data['password']=makePassword($param['repass']);
            $res = $m->editMember($data);
            if ($res['code']===0){
                session('member_id',null);
                session('member_info',null);
            }
            return json($res);
        }
    }
}