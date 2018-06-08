<?php
namespace app\admin\validate;
use think\Validate;

class Article extends Validate
{
    //验证方式
    protected $rule =   [
    'title'     => 'require|max:100|unique:links',
    ];

    //验证规则
    protected $message  =   [
    'title.require' => '名称必须有',
    'title.max'     => '名称最多不能超过100个字符',
    'title.unique'  => '名称不能重复',

    ];

    //场景验证
    protected $scene = [

    ];
}