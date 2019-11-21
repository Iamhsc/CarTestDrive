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
        return $this->fetch();
    }

    public function edit(){
        $m=new \app\admin\model\Member();
        $uid=session('member_id');
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
            $uid=session('member_id');
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
                session('real_name',null);
                session('username',null);
            }
            return json($res);
        }
    }
}