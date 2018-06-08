<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
use app\admin\model\Admin;

class Login extends Controller
{
    public  function index()
    {
        if(request()->isPost()){
            $login=new Admin();
            $status=$login->login(input('username'),input('password'),input('code'));
            if($status == 1){
                return $this->success('登陆成功！~',url('index/index'));
            }elseif($status == 2){
                return $this->error('登陆失败！');
            }elseif($status == 3){
                return $this->error('请检查你的验证码！');
            }else{
                return $this->error('用户名不存在！');
            }
        }
        return $this->fetch('login');
    }

    public function logout(){
        session(NULL);
        return $this->success('退出成功',url('index'));
    }
}
