<?php
namespace app\index\controller;
use app\index\controller\Base;
class Article extends Base
{
    public function index()
    {
        $artid=input('artid');
        db('article')->where(array('id'=>$artid))->setInc('click');
        $articles=db('article')->find($artid);  //当前文章所属ID
        $article=new \app\index\model\Article();

        $hotRes=$article->getHotRes($articles['cateid']);
        $doyouLike=db('article')->where(array('rec'=>$artid,'rec'=>1))->limit(3)->select();
        $this->assign(array(
            'articles'=>$articles,
            'hotRes'=>$hotRes,
            'doyouLike'=>$doyouLike,
        ));
        return view('article');
    }
}
