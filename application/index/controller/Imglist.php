<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\Model\Article;

class Imglist extends Base
{
    public function index()
    {
        $article=new Article();
        $artRes=$article->getAllArticles(input('cateid'));
        $this->assign('artRes',$artRes);
        return view('imglist');
    }
}
