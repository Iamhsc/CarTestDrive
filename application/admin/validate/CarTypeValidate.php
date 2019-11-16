<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/16
 * Time: 16:55
 */

namespace app\admin\validate;


use think\Validate;

class CarTypeValidate extends Validate
{
    protected $rule = [
        'type_name' => 'require',
    ];

    protected $message = [
        'type_name.require' => '类型名不能为空',
    ];
}