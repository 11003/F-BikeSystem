<?php
namespace app\index\controller;
use app\index\controller\Base;
class Page extends Base
{
    public function index()
    {
        $cates=db('cate')->find(input('cateid'));
        $this->assign('cates',$cates);
        return view('page');
    }
}