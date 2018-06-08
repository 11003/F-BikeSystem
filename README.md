# F-BaiQiZhe


:bike: 

## 前台展示

![](https://upload-images.jianshu.io/upload_images/12353119-4351866811b50993.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
![](https://upload-images.jianshu.io/upload_images/12353119-2ec11551fc41d172.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


## 后台展示

![](https://upload-images.jianshu.io/upload_images/12353119-007df081ed6dbd1d.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

## 有关图片本地上传修改并删除原文件代码
	 

#### ModelArticle.php	



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
		
#### ControllerArticle.php	
	
	public  function edit()
	    {
		if(request()->isPost()){
		    $article=new ArticleModel();
		    $save=$article->update(input('post.'));
		    $va=\think\Loader::validate('Article');
		    if(!$va->check(input('post.'))){
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
#### 展示图片只是便于本人好认识它...
