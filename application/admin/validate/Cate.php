<?php
namespace app\admin\validate;
use think\Validate;

class Cate extends Validate
{
    //验证方式
    protected $rule =   [
    'catename'     => 'require|max:10|unique:cate',
    'type'         =>  'require'
    ];

    //验证规则
    protected $message  =   [
    'catename.require' => '名称必须有',
    'type.require' => '值必须有',
    'catename.max'     => '名称最多不能超过10个字符',
    'catename.unique'  => '名称不能重复',
    ];


}