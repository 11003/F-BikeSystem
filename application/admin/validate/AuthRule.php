<?php
namespace app\admin\validate;
use think\Validate;

class AuthRule extends Validate
{
    //验证方式
    protected $rule =   [
    'title'     => 'require|max:10|unique:auth_rule',
    'name'     => 'require|max:10|unique:auth_rule',

    ];

    //验证规则
    protected $message  =   [
    'title.require' => '名称必须有',
    'title.max'     => '名称最多不能超过10个字符',
    'title.unique'  => '名称不能重复',
    'name.require' => '控制和方法必须有',
    'name.max'     => '控制和方法最多不能超过10个字符',
    'name.unique'  => '控制和方法不能重复',

    ];

    //场景验证
    protected $scene = [
        'edit'  =>  ['name'],
    ];
}