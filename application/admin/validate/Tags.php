<?php
namespace app\admin\validate;
use think\Validate;

class Tags extends Validate
{
    //验证方式
    protected $rule =   [
    'tagname'     => 'require|max:6|unique:tags',
    ];

    //验证规则
    protected $message  =   [
    'tagname.require' => '名称必须有',
    'tagname.max'     => '名称最多不能超过6个字符',
    'tagname.unique'  => '名称不能重复',
    ];


}