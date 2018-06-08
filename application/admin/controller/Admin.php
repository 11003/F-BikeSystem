<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Admin as AdminModel;
class Admin extends Base
{
    public  function add()
    {
        if(request()->isPost())
        {
            $data=input('post.');
            $va=\think\Loader::validate('Admin');
            if(!$va->scene('add')->check($data)){
                $this->error($va->getError());
            }
            $admin=new AdminModel();
            if($admin->addadmin($data)){
                $this->success('管理员添加成功','lis');
            }else{
                $this->error('管理员添加失败');
            }
            return;
        }
        $authGroupRes=db('auth_group')->select();
        $this->assign('authGroupRes',$authGroupRes);
        return view();
    }
    public function lis()
    {
        $auth=new Auth();
        $admin=new AdminModel();
        $res=$admin->getadmin();
        foreach ($res as $k => $v) {
            $_groupTitle=$auth->getGroups($v['id']);
            $groupTitle=$_groupTitle[0]['title'];
            $v['groupTitle']=$groupTitle;
        }
        $this->assign('res',$res);
        return view();
    }

    public function edit($id)
    {
        $admins=db('admin')->find($id);

        if(request()->isPost()){
            $data=input('post.');
            $va=\think\Loader::validate('Admin');
            if(!$va->scene('edit')->check($data)){
                $this->error($va->getError());
            }
            $admin=new AdminModel();
            $savenum=$admin->editadmin($data,$admins);
            if($savenum == '2'){
                $this->error('管理员用户名不能空');
            }
            if($savenum !== false){
                $this->success('修改成功!','lis');
            }else{
                $this->error('修改失败');
            }
            return;
        }
        if(!$admins){
            $this->error('该管理员不存在!');
        }
        $authGroupAccess=db('auth_group_access')->where(array('uid'=>$id))->find();
        $authGroupRes=db('auth_group')->select();
        $this->assign([
            'admin' => $admins,
            'authGroupRes' => $authGroupRes,
            'groupId' => $authGroupAccess['group_id']
        ]);
        return view();
    }

    public  function del($id)
    {

        $admin=new AdminModel();
        $delnum=$admin->deladmin($id);
        if(input('id') == '1'){return $this->error('无法操作!');}
        if($delnum == 1){
            return $this->success('管理员删除成功','lis');
        }else{
            return $this->error('管理员删除失败');
        }
    }
}
