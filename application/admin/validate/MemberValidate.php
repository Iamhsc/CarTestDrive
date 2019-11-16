<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/16
 * Time: 16:55
 */

namespace app\admin\validate;


use think\Validate;

class MemberValidate extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require|alphaNum',
        'real_name' => 'require',
        'member_mobile' => 'require|regex:^1\d{10}',
        'member_email' => 'email',
        'member_id_number' => 'require|min:18|max:18',
    ];

    protected $message = [
        'username.require' => '会员名称不能为空',
        'password.require' => '会员密码不能为空',
        'real_name.require' => '真实姓名不能为空',
        'member_mobile.require' => '手机号不能为空',
        'member_mobile.regex' => '手机号不正确',
        'member_id_number.require' => '身份证号不能为空',
        'member_id_number.min' => '身份证号只能18位',
        'member_id_number.max' => '身份证号只能18位'
    ];

    protected $scene = [
        'edit' => ['username', 'real_name', 'member_mobile', 'member_id_number']
    ];
}