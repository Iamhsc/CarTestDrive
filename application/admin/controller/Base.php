<?php
/**
 * Created by PhpStorm.
 * Member: NickBai
 * Email: 876337011@qq.com
 * Date: 2019/2/28
 * Time: 8:24 PM
 */
namespace app\admin\controller;

use think\Controller;
use tool\Auth;

class Base extends Controller
{
    /**
     * 后台控制器基类初始化；（除了登录所有操作都经过这个方法）
     * @return \think\response\Json|void
     */
    public function initialize()
    {
        if(empty(session('admin_user_name'))){

            $this->redirect(url('login/index'));
        }

        $controller = lcfirst(request()->controller());
        $action = request()->action();
        $checkInput = $controller . '/' . $action;

        $authModel = Auth::instance();
        $skipMap = $authModel->getSkipAuthMap();

        if (!isset($skipMap[$checkInput])) {

            $flag = $authModel->authCheck($checkInput, session('admin_role_id'));

            if (!$flag) {
                if (request()->isAjax()) {
                    return json(reMsg(-403, '', '无操作权限'));
                } else {
                    $this->error('无操作权限');
                }
            }
        }

        $this->assign([
            'admin_name' => session('admin_user_name'),
            'admin_id' => session('admin_user_id')
        ]);
    }
}