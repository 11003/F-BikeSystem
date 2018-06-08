<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;
class Cate extends Base
{
    protected $beforeActionList = [
        'delsoncate' => ['only' => 'del'],
    ];
    public function lis(){
        $cate =new CateModel();
        if(request()->isPost()){
            $sort=input('post.');
            foreach($sort as $k => $v){
                $cate->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('排序成功','lis','',1);
            return;
        }
        $cateres=$cate->catetree();
        $this->assign('cateres',$cateres);
        return $this->fetch();
    }

    public function add(){
        $cate=new CateModel();
        if(request()->isPost()){
            $data=[
                'pid'   =>      input('pid'),
                'catename'  =>  input('catename'),
                'type'  =>      input('type'),
                'keywords'  =>  input('keywords'),
                'desc' =>       input('desc'),
                'content' =>    input('content'),
                'rec_index'=>   input('rec_index'),
                'rec_bottom'=>   input('rec_bottom'),
            ];
            $va=\think\Loader::validate('Cate');
            if(!$va->check($data)){
                return $this->error($va->getError($data));
            }
            $res=db('cate')->insert($data);
            if($res){
                return $this->success('添加成功','lis');
            }else{
                return $this->error('添加失败');
            }
        }
        $cateres=$cate->catetree();
        $this->assign('cateres',$cateres);
        return $this->fetch();
    }

    public function edit(){
        if(request()->isPost()){
            $data=[
                'id'       => input('id'),
                'catename' => input('catename'),
                'pid'      => input('pid'),
                'type'     => input('type'),
                'content'   =>input('content'),
                'rec_index'=>   input('rec_index'),
                'rec_bottom'=>   input('rec_bottom'),
            ];
            $validate=\think\Loader::validate('Cate');
            if($validate->check($data)){
                $res=db('cate')->update($data);
                if($res){
                    return $this->success('修改成功','lis');
                }else{
                    return $this->error('修改失败');
                }
            }else{
                return $this->error($validate->getError($data));
            }
        }
        $cate = new CateModel();
        $cates = $cate->find(input('id'));
        $cateres= $cates->catetree();
        $this->assign(array(
            //得到的栏目
            'cateres' => $cateres,
            //当前要编辑的栏目
            'cates' => $cates,
        ));
        return $this->fetch();
    }

    public function del(){
        $res=db('cate')->delete(input('id'));
        if($res){
            return $this->success('删除成功!','lis','',1);
        }else{
            return $this->error('删除失败');
        }
    }

    public function delsoncate(){
        $cateid=input('id');
        $cate = new CateModel();
        $sonids=$cate->getchildrenid($cateid);
        //删除栏目的同时也删除文章
        $allcateid=$sonids;
        $allcateid[]=$cateid;
        foreach($allcateid as $k=>$v){
            $article=new ArticleModel();
            $article->where(array('cateid'=>$v),input('pic'))->delete();
        }
        //如果有子栏目
        if($sonids){
           db('cate')->delete($sonids);
        }
    }
}


