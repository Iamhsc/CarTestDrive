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
        if (empty(session('username'))) {
            $this->redirect(url('index/login'));
        } else {
            $this->assign([
                'real_name' => session('real_name'),
                'member_id' => session('member_id')
            ]);
        }

    }
}