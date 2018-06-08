<?php
namespace app\index\controller;
use app\index\model\Article;
class Search extends Base
{
    public function index()
    {
        $keywords=input('keywords');
        $article=new Article();
        $artRes=$article->getSerHot();
        $searchRes=db('article')
            ->order('id desc')
            ->where('title','like','%'.$keywords.'%')
            ->paginate(2,false,$config=['query'=>array('keywords'=>$keywords)]);
        $this->assign(array(
            'searchRes'=>$searchRes,
            'keywords' =>$keywords,
            'artRes'=> $artRes,
        ));
        return view('search');
    }
}
