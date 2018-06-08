<?php
namespace app\index\Model;
use think\Model;
use app\index\model\Cate;
class Article extends Model
{
    //所有文章
    public function getAllArticles($cateid){
        $cate=new Cate();
        $allCateId=$cate->getchildrenid($cateid);
        $artRes=db('article')->where("cateid IN($allCateId)")->order('id desc')->paginate(6);
        return $artRes;
    }

    //热门文章
    public function getHotRes($cateid){
        $cate=new Cate();
        $allCateId=$cate->getchildrenid($cateid);
        $artRes=db('article')->where("cateid IN($allCateId)")->order('click desc')->limit(5)->select();
        return $artRes;
    }
    //首页右侧热门文章
    public function getSizeHot(){
        $sizeHotArt=$this->field('id,title,pic')->order('click desc')->limit(5)->select();
        return $sizeHotArt;
    }
    //友情链接
    public function getLinks(){
        $LinksRes=db('links')->order('sort desc')->select();
        return $LinksRes;
    }
    //获取首页最新文章
    public function getNewAritcle(){
        $newArticleRes=db('article')
            ->alias('a')
            ->field('a.id,a.title,a.desc,a.pic,a.time,a.zan,a.content,a.click,c.catename')
            ->join('bk_cate c','a.cateid=c.id')
            ->order('a.id desc')
            ->limit(10)
            ->select();

        return $newArticleRes;
    }
    //推荐
    public function getRecArt(){
        $resArt=$this->field('id,title,pic')->where('rec','=',1)->order('id desc')->limit(4)->select();
        return $resArt;
    }

}
