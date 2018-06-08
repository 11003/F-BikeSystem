<?php
namespace app\index\controller;
use think\Controller;
class Index extends Base
{
    public function index()
    {
        //首页最新文章调用
        $articleM=new \app\index\model\Article();
        $cateM=new \app\index\model\Cate();
        $newArticleRes=$articleM->getNewAritcle();
        $sizeHotArt=$articleM->getSizeHot();
        $linkRes=$articleM->getLinks();
        $resArt=$articleM->getRecArt();
        $recIndex=$cateM->getIndexRec();
        $this->assign(array(
            'newArticleRes' =>$newArticleRes,
            'sizeHotArt'    =>$sizeHotArt,
            'linkRes'       =>$linkRes,
            'resArt'        =>$resArt,
            'recIndex'      =>$recIndex,
        ));
        return view();
    }
}
