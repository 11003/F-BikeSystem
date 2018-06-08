<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Article as ArticleModel;
use app\admin\model\Cate as CateModel;
class Article extends Base
{
    public  function lis()
    {
        $artres=db('article')
            ->alias('a')
            ->field('a.*,b.catename')
            ->join('cate b','a.cateid=b.id')
            ->order('a.id desc')
            ->paginate(10);
        $this->assign('artres',$artres);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
            $data=input('post.');
            $data['time']=time();
            $va=\think\Loader::validate('Article');
            if(!$va->check($data)){
                return $this->error($va->getError($data));
            }
            $article=new ArticleModel();
            if($article->save($data)){
                $this->success('添加文章成功!','lis');
            }else{
                $this->error('添加文章失败!','lis');
            }
            return;
        }
        $cate=new CateModel();
        $cateres=$cate->catetree();
        $this->assign('cateres',$cateres);
        return $this->fetch();
    }

    public  function edit()
    {
        if(request()->isPost()){
            $article=new ArticleModel();
            $save=$article->update(input('post.'));
            $va=\think\Loader::validate('Article');
            if(!$va->scene('edit')->check(input('post.'))){
                return $this->error($va->getError(input('post.')));
            }
            if($save){
                $this->success('修改文章成功!','lis','',1);
            }else{
                $this->error('修改文章失败!');
            }
            return;
        }
        $cate=new CateModel();
        $cateres=$cate->catetree();
        $id=input('id');
        $artres=db('article')->find($id);
        $this->assign(array(
            'artres' => $artres,
            'cateres' => $cateres
        ));

        return $this->fetch();
    }

    public  function del()
    {
       if(ArticleModel::destroy(input('id'))){
           $this->success('删除文章成功!','lis','',1);
       }else{
           $this->error('删除文章失败!');
       }
        return;
    }
}
