<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Links as LinksModel;

class Links extends Base
{
    public  function lis()
    {
        $link=new LinksModel();
        if(request()->isPost()){
            $sort=input('post.');
            foreach($sort as $k=>$v){
                $link->update([
                    'id' => $k,
                    'sort' => $v
                ]);
                $this->success('排序成功','lis');
                return;
            }

        }
        $linkres=$link->order('sort desc')->paginate(3);
        $this->assign('linkres',$linkres);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()) {
            $links=new LinksModel();
            $validate=\think\Loader::validate('Links');
            if($validate->check(input('post.'))){
                $add=$links->insert(input('post.'));
                if($add){
                    $this->success('添加链接成功','lis','',1);
                }else{
                    $this->error('添加链接失败');
                }
            }else{
                $this->error($validate->getError(input('post.')));
            }
            return;
        }
        return $this->fetch();
    }

    public  function edit()
    {
        $link=new LinksModel();
        $id=input('id');
        if(request()->isPost()){
            $validate=\think\Loader::validate('Links');
            if($validate->scene('edit')->check(input('post.'))){
                $edit=LinksModel::update(input('post.'));
                if($edit){
                    $this->success('修改链接成功','lis','',1);
                }else{
                    $this->error('修改链接失败');
                }
            }else{
                $this->error($validate->getError(input('post.')));
            }
        }
        $linkres=$link->find($id);
        $this->assign('linkres',$linkres);
        return $this->fetch();
    }

    public  function del()
    {
        $del=db('links')->delete(input('id'));
        if($del){
            $this->success('删除链接成功','lis','',1);
        }else{
            $this->error('修改链接失败');
        }
        return $this->fetch();
    }
}
