<?php
namespace app\index\Model;
use think\Model;
class Cate extends Model
{
    //找出子栏目
    public function getchildrenid($cateid){
        $cateres=$this->select();
        if($cateres){
            $arr=$this->_getchildrenid($cateres,$cateid);
            $arr[]=$cateid;
            $strId=implode(',',$arr);
            return $strId;
        }

    }
    public function _getchildrenid($cateres,$cateid){
        static $arr=array();
        foreach($cateres as $k=>$v){
            if($v['pid'] == $cateid){
                $arr[]=$v['id'];
                //防止无下限循环
                $this->_getchildrenid($cateres,$v['id']);
            }
        }
        return $arr;
    }

    public function getparents($cateid){
        $cateres=$this->field('id,pid,catename')->select();
        $cates=db('cate')->field('id,pid,catename')->find($cateid);
        $pid=$cates['pid'];
        if($pid){
            $arr=$this->_getparentsid($cateres,$pid);
        }
            $arr[]=$cates;
            return $arr;
    }
    public function _getparentsid($cateres,$pid){
        static $arr=array();
        foreach($cateres as $k=>$v){
            if($v['id'] == $pid){
                $arr[]=$v;
                //防止无下限循环
                $this->_getparentsid($cateres,$v['pid']);
            }
        }
        return $arr;
    }
    //首頁、底部推薦信息
    public function getIndexRec(){
        $recIndex=$this->order('id desc')->where('rec_index','=',1)->select();
        return $recIndex;
    }
    public function getBottomRec(){
        $recBottom=$this->order('id desc')->where('rec_bottom','=',1)->select();
        return $recBottom;
    }

    public function getCateInfo($cateid){
        $cateInfo=$this->field('catename,keywords,desc')->find($cateid);
        return $cateInfo;
    }
}
