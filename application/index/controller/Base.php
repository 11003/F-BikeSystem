<?php
namespace app\index\controller;
use think\Controller;
class Base extends Controller
{
    public function _initialize()
    {
        //当前网站
        if(input('cateid')){
            $this->getPos(input('cateid'));
        }
        if(input('artid')){
            $articles=db('article')->field('cateid')->find(input('artid'));
            $cateid=$articles['cateid'];
            $this->getPos($cateid);
        }
        //网站配置项
        $this->getConf();
        //网站栏目导航
        $this->getNavCates();
        //底部公用導航信息
        $cateM=new \app\index\model\Cate();
        $recBottom=$cateM->getBottomRec();
        $cateid=input('cateid');
        $cateInfo=$cateM->getCateInfo($cateid);
        $this->assign([
            'recBottom'=>$recBottom,
            'cateInfo' =>$cateInfo
        ]);
    }

    //导航栏目
    public function getNavCates(){
        $cateres=db('cate')->where(array('pid'=>0))->select();
        //找出下拉导航
        foreach($cateres as $k =>$v){
            $children=db('cate')->where(array('pid'=>$v['id']))->select();
            if($children){
                $cateres[$k]['children']=$children;
            }else{
                $cateres[$k]['children']=0;
            }
        }
        $this->assign('cateres',$cateres);
    }
    public function getConf(){
        $conf=new \app\index\model\Conf();
        $_confres=$conf->getAllConf();
        $confres=array();
        foreach($_confres as $k=>$v){
            $confres[$v['enname']]=$v['cnname'];
        }
        $this->assign('confres',$confres);
    }
    public function getPos($cateid){
        $cate=new \app\index\model\Cate();
        $posAll=$cate->getchildrenid(input('cateid'));
        $this->assign('posAll',$posAll);
    }

    //搜索頁熱門文章
    public function getSerHot(){
        $hotRes=db('article')->order('click desc')->limit(5)->select();
        return $hotRes;
    }

}
