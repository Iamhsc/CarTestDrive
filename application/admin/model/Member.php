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

    /**
     * 获取会员列表
     * @param $limit
     * @param $where
     * @return array
     * @throws \think\exception\DbException
     */
    public function getMemberList($limit, $where){
        $ls=self::where($where)
            ->order('member_id', 'desc')->paginate($limit);
        return modelReMsg(0,$ls,'ok');
    }

    /**
     * 登录
     * @param $param
     * @return array|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($param){
        return self::where(['member_email'=>$param['email'],'is_del'=>0,'status'=>1])->find();
    }

    /**
     * 根据id获取单个会员信息
     * @param $id
     * @return array|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMemberById($id){
        return self::where('member_id',$id)->find();
    }

    /**
     * 添加会员
     * @param $data
     * @return array|bool
     */
    public function addMember($data){
        $count=self::where('username',$data['username'])->count();
        if ($count>0)
            return modelReMsg(-1, '', '该会员名已存在');
        $id=self::save($data);
        if ($id)
            return modelReMsg(0, '', '添加会员成功');
        return modelReMsg(-1, '', '添加会员失败');
    }

    /**
     * 编辑会员信息
     * @param $data
     * @return array
     */
    public  function editMember($data){
        $edit = self::save($data,['member_id'=>$data['member_id']]);
        if ($edit)
            return modelReMsg(0, '', '修改成功');
        return modelReMsg(-1, '', '修改失败');
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
     * 更新登陆时间
     * @param $id
     * @return bool
     */
    public function updateLoginTime($id){
        $this->autoWriteTimestamp=false;
        return self::save(['last_login_time'  => strtotime(date("H:i:s",time()))],['member_id' => $id]);
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