<?php
namespace app\Admin\model;
use think\Model;

class Cate extends Model
{
    public function catetree(){
        $cateres=$this->order('sort desc')->select();
        return $this->sort($cateres);
    }
    //pid顶级栏目，level下级栏目

    public function sort($data,$pid=0,$level=0){
        static $arr=array();
        foreach($data as $k=>$v){
            //1找出顶级栏目
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                //递归
                $this->sort($data,$v['id'],$level+1);

            }
        }
        return $arr;
    }

    //删除父栏目，子栏目也会消失
    public function getchildrenid($cateid){
        $cateres=$this->select();
        if($cateres){
            return $this->_getchildrenid($cateres,$cateid);
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


}
