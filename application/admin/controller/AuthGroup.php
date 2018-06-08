<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\AuthGroup as AuthGroupModel;

class AuthGroup extends Base
{
    public  function lis()
    {
        $authGroupRes=AuthGroupModel::paginate(10);
        $this->assign('authGroupRes',$authGroupRes);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
            $data=input('post.');
            if($data['rules']){
                $data['rules']=implode(',',$data['rules']); //  把数组转换成字符串
            }
            $res=db('auth_group')->insert($data);
            if($res){
                $this->success('新增用户组成功','lis');
            }else{
                $this->error('新增用户组失败');
            }
            return;
        }
        //分配配置权限
        $authRule=new \app\Admin\model\AuthRule();
        $authRuleRes=$authRule->authRuleTree();
        $this->assign('authRuleRes',$authRuleRes);
        return $this->fetch();
    }

    public function edit(){
        if(request()->isPost()){
            $data=input('post.');
            if($data['rules']){
                $data['rules']=implode(',', $data['rules']);
            }
            $_data=array();
            foreach ($data as $k => $v) {   //字符串按升序排列
                $_data[]=$k;
            }
            if(!in_array('status', $_data)){
                $data['status']=0;
            }
            $save=db('auth_group')->update($data);
            if($save!==false){
                $this->success('修改用户组成功！',url('lis'));
            }else{
                $this->error('修改用户组失败！');
            }
            return;
        }
        $authgroups=db('auth_group')->find(input('id'));
        $authRule=new \app\admin\model\AuthRule();
        $authRuleRes=$authRule->authRuleTree();
        $this->assign([
            'authgroups'=> $authgroups,
            'authRuleRes'=> $authRuleRes
        ]);
        return view();
    }

    public  function del()
    {
        $del=AuthGroupModel::destroy(input('id'));
        if($del){
            $this->success('删除用户组成功','lis');
        }else{
            $this->error('删除用户组失败');
        }

    }
}
