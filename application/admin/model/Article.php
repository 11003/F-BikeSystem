<?php
namespace app\Admin\model;
use think\Model;

class Article extends Model
{
    protected static function init(){
        Article::event('before_insert',function($data){
            if($_FILES['pic']['tmp_name']){
                $file=request()->file('pic');
                $info=$file->move(ROOT_PATH.'public'.DS.'uploads');
                if($info){
                    $pic='/uploads'.'/'.date('Ymd').'/'.$info->getFilename();
                    $data['pic']=$pic;
                }
            }
        });

        Article::event('before_update',function($data){
            if($_FILES['pic']['tmp_name']){
                //删除原有的图片
                $arts=Article::find($data->id);
                $picpath=$_SERVER['DOCUMENT_ROOT'].$arts['pic'];
                //判断文件是否存在file_exists
                if(file_exists($picpath)){
                    @unlink($picpath);
                }
                $file=request()->file('pic');
                $info=$file->move(ROOT_PATH.'public'.DS.'uploads');
                if($info){
                    $pic='/uploads'.'/'.date('Ymd').'/'.$info->getFilename();
                    $data['pic']=$pic;
                }
            }
        });

        Article::event('before_delete',function($data){
                //删除原有的图片
                $arts=Article::find($data->id);
                $picpath=$_SERVER['DOCUMENT_ROOT'].$arts['pic'];
                //判断文件是否存在file_exists
                if(file_exists($picpath)){
                    @unlink($picpath);
                }
        });
    }
}
