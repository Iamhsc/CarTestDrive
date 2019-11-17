<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/16
 * Time: 16:55
 */

namespace app\admin\validate;


use think\Validate;

class CarBrandValidate extends Validate
{
    protected $rule = [
        'brand_name' => 'require',
    ];

    protected $message = [
        'brand_name.require' => '类型名不能为空',
    ];
}