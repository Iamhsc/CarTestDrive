<?php
/**
 * Created by PhpStorm.
 * Member: imhsc
 * Date: 2019/11/15
 * Time: 11:38
 */

namespace app\admin\model;


use think\Model;

class Member extends Model
{
    protected $table="ctd_member";
    protected $autoWriteTimestamp = true;

    // 格式化最后登录时间
    public function getLastLoginTimeAttr($value)
    {
        return date('Y-m-d H:i', $value);
    }
    // 获取最后登陆ip
    public function setLastLoginIpAttr($value)
    {
        return get_client_ip();
    }

    public function getMemberList($limit, $where){
        $ls=self::where($where)
            ->order('member_id', 'desc')->paginate($limit);
        return modelReMsg(0,$ls,'ok');
    }

    public function getMemberById(){

    }

    /**
     * 添加会员
     * @param $data
     * @return array|bool
     */
    public function addMember($data){
        $count=self::where('username',$data['username'])->count();
        if ($count>0)
            return modelReMsg(-1, '', '该会员已存在');
        $id=self::save($data);
        if ($id)
            return modelReMsg(0, '', '添加会员成功');
        return modelReMsg(-1, '', '添加会员失败');
    }

    public  function editMember(){
    }

    /**
     * 改变会员状态
     * @param $id
     * @param $val
     * @return bool
     */
    public function updateStatus($id,$val){
        return self::save(['status'  => $val],['member_id' => $id]);
    }

    /**
     * 删除会员
     * @param $id
     * @return bool
     */
    public function delMember($id){
        return self::save(['is_del'  => 1],['member_id' => $id]);
    }
}