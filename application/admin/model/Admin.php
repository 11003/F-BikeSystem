<?php
namespace app\admin\model;
use think\Model;
use think\Db;
use think\captcha\Captcha;
use think\Session;
class Admin extends Model
{
    public function addadmin($data){

        if(empty($data) || !is_array($data)){
            return false;
        }
        if($data['password']){
            $data['password']=md5($data['password']);
        }
        $adminData=array();
        $adminData['username']=$data['username'];
        $adminData['password']=$data['password'];
        if($this->save($adminData)){
            $groupAccess['uid']=$this->id;
            $groupAccess['group_id']=$data['group_id'];
            db('auth_group_access')->insert($groupAccess);
            return true;
        }else{
            return false;
        }
    }

    public function getadmin(){
        return $this::paginate(5);
    }

    public function editadmin($data,$admins){
        if(empty($data) || !is_array($data)){
            return false;
        }
        if(!$data['username']){
            return 2;//管理员用户名为空
        }
        if(!$data['password']){
            $data['password']=$admins['password'];
        }else{
            $data['password']=md5($data['password']);
        }
        db('auth_group_access')->where(array('uid'=>$data['id']))->update(['group_id'=>$data['group_id']]);
        return $this::update(['username'=>$data['username'],'password'=>$data['password']],['id'=>$data['id']]);
    }

    public function deladmin($id)
    {
       if( $this::destroy($id)){
           return 1;
       }else{
           return 2;
       }
    }

    public function login($username,$password,$code)
    {
        $admin=Db::name('admin')->where('username','=',$username)->find();
        $captcha=new Captcha();

        if($admin){
            if($admin['password'] == md5($password)){
                if(!$captcha->check($code)){
                    return 3;
                }
                Session::set('id',$admin['id']);//检测每个页面是否登录
                Session::set('username',$admin['username']);
                return 1;
            }else{
                return 2;
            }
        }else{
            return 4;
        }
    }
}
