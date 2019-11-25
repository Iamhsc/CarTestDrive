<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/18
 * Time: 21:19
 */

namespace app\home\controller;


use think\Controller;

class Base extends Controller
{
    public function initialize()
    {
        if (empty(session('member_id'))) {
            $this->redirect(url('index/login'));
        } else {
            $this->assign([
                'member_info'=> session('member_info'),
            ]);
        }

    }

    public function uid(){
        return session('member_id');
    }
}