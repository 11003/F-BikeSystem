<?php
namespace app\admin\validate;
use think\Validate;

class Links extends Validate
{
    //验证方式
    protected $rule =   [
    'title'     => 'require|max:10|unique:links',
    'url'       => 'url|require|min:5|unique:links',
    'desc'      => 'require'
    ];

    //验证规则
    protected $message  =   [
    'title.require' => '名称必须有',
    'title.max'     => '名称最多不能超过10个字符',
    'title.unique'  => '名称不能重复',
    'url.min'       => '地址最多不能小于5个字符',
    'url.require'   => '地址必须有',
    'url.unique'    =>  '链接地址不能重复',
    'url.url'       =>  '链接地址格式不正确',
    'desc.require'   => '描述总要有吧?!',
    ];

    //场景验证
    protected $scene = [
        'edit'  =>  ['title','url'],
    ];
}