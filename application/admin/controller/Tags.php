<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Tags extends Base
{
    public  function lis()
    {
        $tags=Db::name('tags')->paginate(5);
        $this->assign('tags',$tags);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost())
        {
            $data = [
                'tagname' => input('tagname'),
            ];
            $validate=\think\Loader::validate('Tags');
            if($validate->check($data)){
                $res=db('tags')->insert($data);
                if($res){
                    return $this->success('标签添加成功','lis');
                }else{
                    return $this->error('标签添加失败');
                }
            }else{
                return $this->error($validate->getError());
            }
        }
        return $this->fetch();
    }

    public  function edit()
    {
        $id=input('id');
        if(request()->isPost())
        {
            $data = [
                'id'    => input('id'),
                'tagname' => input('tagname'),
            ];
            $validate=\think\Loader::validate('Tags');
            if($validate->check($data))
            {
                $res=db('tags')->update($data);
                if($res){
                    return $this->success('标签修改成功','lis');
                }else{
                    return $this->error('标签修改失败');
                }
            }else{
                return $this->error($validate->getError());
            }
        }
        $res=db('tags')->where('id',$id)->find();
        $this->assign('res',$res);
        return $this->fetch();
    }

    public  function del()
    {
        $res=db('tags')->delete(input('id'));
        if($res){
            return $this->success('标签删除成功','lis');
        }else{
            return $this->error('标签删除失败');
        }
        return $this->fetch();
    }
}
