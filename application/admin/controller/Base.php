<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
use think\Request;

class Base extends Controller
{
    public  function _initialize()
    {
        if(!session('id') || !session('username')){
            return $this->error('您尚未登陆系统!',url('Login/index'));
        }

        $auth=new Auth();
        $request=Request::instance();   //当前路径
        $con=$request->controller();    //当前控制器
        $action=$request->action();     //当前方法
        $name=$con.'/'.$action;
        $notCheck=array('Index/index','Admin/lst','Admin/logout');
//          if(session('id')!=1){
//          	if(!in_array($name, $notCheck)){
//          		if(!$auth->check($name,session('id'))){
//         $this->error('没有权限',url('index/index'));
//         }
//          	}
//
//          }
    }


}
