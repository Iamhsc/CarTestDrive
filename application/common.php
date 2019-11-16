<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use tool\Auth;

if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端IP地址
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    function get_client_ip($type = 0, $adv = false) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($adv){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}


/**
 * 生产密码
 * @param $password
 * @return string
 */
function makePassword($password) {

    return md5($password . config('whisper.salt'));
}

/**
 * 检测密码
 * @param $dbPassword
 * @param $inPassword
 * @return bool
 */
function checkPassword($inPassword, $dbPassword) {
	
    return (makePassword($inPassword) == $dbPassword);
}

/**
 * 获取mysql 版本
 * @return string
 */
function getMysqlVersion() {

    $conn = mysqli_connect(
        config('database.hostname') . ":" . config('database.hostport'),
        config('database.username'),
        config('database.password'),
        config('database.database')
    );

    return mysqli_get_server_info($conn);
}

/**
 * 生成layui子孙树
 * @param $data
 * @return array
 */
function makeTree($data) {

    $res = [];
    $tree = [];

    // 整理数组
    foreach ($data as $key => $vo) {
        $res[$vo['id']] = $vo;
        $res[$vo['id']]['children'] = [];
    }
    unset($data);

    // 查询子孙
    foreach ($res as $key => $vo) {
        if($vo['pid'] != 0){
            $res[$vo['pid']]['children'][] = &$res[$key];
        }
    }

    // 去除杂质
    foreach ($res as $key => $vo) {
        if($vo['pid'] == 0){
            $tree[] = $vo;
        }
    }
    unset($res);

    return $tree;
}

/**
 * 打印调试函数
 * @param $data
 */
function dump($data) {

    echo "<pre>";
    print_r($data);
}

/**
 * 标准返回
 * @param $code
 * @param $data
 * @param $msg
 * @return \think\response\Json
 */
function reMsg($code, $data, $msg) {

    return json(['code' => $code, 'data' => $data, 'msg' => $msg]);
}

/**
 * model返回标准函数
 * @param $code
 * @param $data
 * @param $msg
 * @return array
 */
function modelReMsg($code, $data, $msg) {

    return ['code' => $code, 'data' => $data, 'msg' => $msg];
}


/**
 * 根据ip定位
 * @param $ip
 * @return string
 * @throws Exception
 */
function getLocationByIp($ip)
{
    $ip2region = new \Ip2Region();
    $info = $ip2region->btreeSearch($ip);

    $info = explode('|', $info['region']);

    $address = '';
    foreach($info as $vo) {
        if('0' !== $vo) {
            $address .= $vo . '-';
        }
    }

    return rtrim($address, '-');
}

/**
 * 按钮检测
 * @param $input
 * @return bool
 */
function buttonAuth($input)
{
    $authModel = Auth::instance();
    return  $authModel->authCheck($input, session('admin_role_id'));
}
