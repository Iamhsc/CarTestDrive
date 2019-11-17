<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/16
 * Time: 16:55
 */

namespace app\admin\validate;


use think\Validate;

class CarValidate extends Validate
{
    protected $rule = [
        'car_model_name' => 'require',
    ];

    protected $message = [
        'car_model_name.require' => '型号不能为空',
    ];
}