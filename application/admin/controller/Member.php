<?php
/**
 * Created by PhpStorm.
 * Member: imhsc
 * Date: 2019/11/15
 * Time: 11:37
 */

namespace app\admin\controller;


use app\admin\validate\MemberValidate;

class Member extends Base
{
    /**
     * 会员列表
     * @return mixed|\think\response\Json
     */
    public function index(){
        if (request()->isAjax()) {
            $limit = input('param.limit');
            $real_name = input('param.real_name');

            $where=[];
            $where[] = ['is_del','=',0];
            if (!empty($real_name)) {
                $where[] = ['real_name', 'like', '%'.$real_name.'%'];
            }

            $member = new \app\admin\model\Member();
            $ls = $member->getMemberList($limit, $where);
            if ($ls['code']===0)
                return json(['code' => 0, 'msg' => 'ok', 'count' => $ls['data']->total(), 'data' => $ls['data']->all()]);
            else
                return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => []]);
        }
        return $this->fetch();
    }


    /**
     * 添加会员
     * @return array|mixed|\think\response\Json
     */
    public function add(){
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new MemberValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $param['password'] = makePassword($param['password']);
            $m = new \app\admin\model\Member();
            $res = $m->addMember($param);
            return json($res);
        }
        return $this->fetch();
    }

    /**
     * 会员删除
     * @return \think\response\Json
     */
    public function del(){
        $param=$this->request->param();
        $member=new \app\admin\model\Member();
        $del=$member->delMember($param['id']);
        if($del)
            return json(['code' => 0, 'msg' => '删了成功', 'count' => 0, 'data' => []]);
        return json(['code' => -1, 'msg' => '删了失败', 'count' => 0, 'data' => []]);
    }

    /**
     * 修改会员状态
     * @return \think\response\Json
     */
    public function status(){
        $param=$this->request->param();
        $m=new \app\admin\model\Member();
        $s=$m->updateStatus($param['id'],$param['val']);
        if ($s)
            return json(['code' => 1, 'msg' => '改状态成功', 'count' => 0, 'data' => []]);
        return json(['code' => 0, 'msg' => '改状态失败', 'count' => 0, 'data' => $param]);
    }
}