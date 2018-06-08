<?php
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    //验证方式
    protected $rule =   [
    'username'  => 'require|max:10|unique:admin',
    'password' => 'require|min:5'
    ];

    //验证规则
    protected $message  =   [
    'username.require' => '名称必须有',
    'username.max'     => '名称最多不能超过10个字符',
    'username.unique'  => '名称不能重复',
    'password.min'  => '密码不能小于5个字符',
    'password.require' => '密码必须有',
    ];

    //场景验证
    protected $scene = [
        'edit'  =>  ['username', 'password'=>'min:5'],
        'add'  =>   ['username', 'password'=>'min:5'],
    ];
}