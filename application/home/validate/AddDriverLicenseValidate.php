<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2019/11/26
 * Time: 19:24
 */

namespace app\home\validate;


use think\Validate;

/**
 * 添加驾驶证验证器
 * Class AddDriverLicenseValidate
 * @package app\home
 */
class AddDriverLicenseValidate extends Validate
{
    protected $rule =   [
        'driver_number'  => 'require',
        'apply_place'   => 'require',
        'apply_date' => 'require',
        'expiry_date' => 'require',
        'driver_type' => 'require',
        'photo' => 'require'
    ];

    protected $message  =   [
        'driver_number.require' => '驾驶证编号不能为空',
        'apply_place.require'   => '申请机关不能为空',
        'apply_date.require'    => '申请日期不能为空',
        'expiry_date.require'   => '到期日期不能为空',
        'driver_type.require'   => '准驾车型不能为空',
        'photo.require'         => '证件照片不能为空'
    ];

}