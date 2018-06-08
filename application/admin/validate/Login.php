<?php
namespace app\admin\validate;
use think\Validate;

class Login extends Validate
{
    //验证方式
    protected $rule = [
        'username' => 'require|unique:login',
        'password' => 'require|unique:login'
    ];

    //验证规则
    protected $message = [
        'username.require' => '名称必须有',
        'password.require' => '地址必须有',
    ];


}