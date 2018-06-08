<?php
namespace app\index\controller;
use app\index\model\Article;
class Artlist extends Base
{
    public function index()
    {
        $article=new Article();
        $artRes=$article->getAllArticles(input('cateid'));
        $hotRes=$article->getHotRes(input('cateid'));
        $cate=new \app\index\model\Cate();
        $posAll=$cate->getparents(input('cateid'));
        $this->assign([
            'artRes' => $artRes,
            'hotRes'=> $hotRes,
            'posAll'=>$posAll
        ]);
        return view('artlist');
    }
}
