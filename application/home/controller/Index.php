<?php

namespace app\home\controller;

use app\admin\model\Car;
use app\admin\model\CarBrand;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $limit=6;
        $where=[];
        $where[] = ['m.is_del','=',0];
        $param=$this->request->param();
        if (isset($param['car_brand_id']))
            $where[] = ['m.car_brand_id', '=', $param['car_brand_id']];

        if (isset($param['limit']))
            $limit = input('param.limit');

        $brand=new CarBrand();
        $car=new Car();
        $cars=$car->getCarList($limit,$where)['data'];
        $this->assign([
            'member_info'    => session('member_info'),
            'brand_ls'  => $brand->getCarBrandList()['data'],
            'car_ls'       =>$cars
        ]);
        return $this->fetch();
    }

    public function login()
    {
        return $this->fetch();
    }

    public function register()
    {
        return $this->fetch();
    }

    public function logout(){
        session('member_info',null);
        session('member_id', null);
        $this->redirect(url('login'));
    }

    //找回密码
    public function forget()
    {
        return $this->fetch();
    }

    public function doRegister()
    {
        if (request()->isPost()) {
            $param = input('post.');
            $email = $param['member_email'];
            if (cache($email) != $param['vercode']) {
                return reMsg(-1, '', '验证码错误');
            }
            unset($param['pass']);
            $param['password'] = makePassword($param['password']);
            $m = new \app\admin\model\Member();
            $res = $m->addMember($param);
            if ($res['code'] === 0)
                cache($email, null);
            return $res;
        }
    }

    public function doLogin()
    {
        if (request()->isPost()) {

            $param = input('post.');

            if (!captcha_check($param['vercode'])) {
                return reMsg(-1, '', '验证码错误');
            }
            $model = new \app\admin\model\Member();
            $info = $model->login($param);
            if (!$info)
                return reMsg(-1, '', '用户不存在或被禁用');

            if (!checkPassword($param['password'], $info['password'])) {
                return reMsg(-3, '', '用户名密码错误');
            }
            $url='/home/member';
            $msg='登录成功';
            if (empty($info['real_name'])) {
                $url = '/home/member/edit';
                $msg ='登陆成功，请完善你的资料';
            }

            // 设置session标识状态
            session('member_id', $info['member_id']);
            session('member_info',$info);
            // 维护上次登录时间
            $model->updateLoginTime($info['member_id']);
            return reMsg(0, $url, $msg);
        }
    }

    public function sendCode()
    {
        $param = input('post.');
        if (\app\admin\model\Member::where('member_email', $param['email'])->count() > 0)
            return ['code' => 0, 'msg' => '该邮箱已注册'];
        $subject = '试驾系统';
        $code = rand(1111, 9999);
        $content = '您的验证码是' . $code . '，如非本人操作请忽略，有效时间15分钟。';
        $res = send_mail($param['email'], $subject, $content);
        if ($res) {
            if (cache($param['email'], $code, 900))
                return ['code' => 1, 'msg' => '已发送'];
        }
    }
}
