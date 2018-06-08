<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Conf as ConfModel;

class Conf extends Base
{
    public  function lis()
    {
        if(request()->isPost()){
            $sort=input('post.');
            $conf=new ConfModel();
            foreach($sort as $k=>$v){
                $conf->update(['id' => $k, 'sort' => $v]);
                $this->success('排序成功','lis');
                return;
            }
        }
        $confres=ConfModel::order('sort desc')->paginate(10);
        $this->assign('confres',$confres);
        return view();
    }

    public function add()
    {
        if(request()->isPost()) {
            $data=input('post.');
            if($data['values']){
                $data['values']=str_replace('，',',',$data['values']);
            }
            $add=new ConfModel();
            if($add->save($data)){
                $this->success('配置添加成功','lis');
            }else{
                $this->error('配置添加失败');
            }
            return;
        }
        return view();
    }

    public  function edit()
    {
        $conf=new ConfModel();
        if(request()->isPost()){
            $data=input('post.');
            if($data['values']){
                $data['values']=str_replace('，',',',$data['values']);
            }
            $save=$conf->save($data,['id'=>$data['id']]);
            if($save !== false){
                return $this->success('修改配置成功','lis');
            }else{
                return $this->error('修改配置失败');
            }
        }
        $confs=$conf->find(input('id'));
        $this->assign('confs',$confs);
        return view();
    }

    public  function del()
    {
        $del=ConfModel::destroy(input('id'));
        if($del){
            $this->success('删除配置成功','lis','',1);
        }else{
            $this->error('删除配置失败');
        }
        return view();
    }

    //配置项
    public function conf(){
        if(request()->isPost()){
            $data=input('post.');
            if($data){
                foreach($data as $k=>$v){
                    ConfModel::where('enname',$k)->update(['value'=>$v]);
                }
                return $this->success('修改成功');
            }
        }
        $confres=ConfModel::order('sort desc')->select();
        $this->assign('confres',$confres);
        return view();
    }
}
