<?php
/**
 * Created by PhpStorm.
 * User: parallels
 * Date: 10/19/18
 * Time: 9:21 AM
 */
namespace app\admin\controller;


use app\admin\model\ArticleModel;

class Article extends ComController{

    public static $articleModel;

    function __construct() {
        parent::__construct();
        self::$articleModel = new ArticleModel();
    }
    /**
     *保存文章内容图片
     */
    public function saveContentImg(){
        $file = request()->file('file');
        $code = 0;//0表示成功，其它失败
        $data = null;
        $msg = '';
        if($file) {
            $info = $file->validate(['size'=>8 * 1024 * 1024,'ext'=>'jpg,png,gif'])->rule('date')->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $data = ['src'=>UPLOAD_PATH.$info->getSaveName(),'title'=>$info->getSaveName()];
                $msg = '图片上传成功';
            }else{
                echo $file->getError();
                $code = -1;
                $msg = '图片保存失败';
            }
        }else{
            $code = -1;
            $msg = '图片上传失败';
        }
        return ['code'=>$code,'msg'=>$msg,'data'=>$data];
    }

    /**
     * 保存文章
     */
    public function saveArticle(){
        if(input('post.articleId/d') != 0){
            $data['id'] = input('post.articleId/d');
        }
        $data['title'] = input('post.title/s');
        $data['introduction'] = input('post.introduction/s');
        $data['content'] = input('post.content/s');
        $data['menuid'] = input('post.menuid/d');
        $cover = request()->file('cover');
        if($cover){
            $info = $cover->validate(['size'=>8 * 1024 * 1024,'ext'=>'jpg,png,gif'])->rule('date')->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $data['cover'] = UPLOAD_PATH.DS.$info->getSaveName();
                $image = \think\Image::open(ROOT_PATH . 'public' . DS . 'uploads/'.$info->getSaveName());
                $image->thumb(150, 150)->save($info->getPath().'/thumb_'.$_SERVER['REQUEST_TIME'].'.'.$image->type());
                $data['thumbnail'] = UPLOAD_PATH.DS.date("Ymd").'/thumb_'.$_SERVER['REQUEST_TIME'].'.'.$image->type();
            }
        }
        $data['addtime'] = $_SERVER['REQUEST_TIME'];
        if(input('post.articleId/d') == 0){
            return ['code'=>self::$articleModel->save($data)];
        }else{
            $data['id'] = input('post.articleId/d');
            if(self::$articleModel->update($data)){
                return ['code'=>1];
            }
            return ['code'=>0];
        }
    }

    /**
     * 获取文章内容
     * @param $articleId
     * @return array
     * @throws \think\exception\DbException
     */
    public function getArticle($articleId){
        $articleModel = ArticleModel::get($articleId);
        return ['code'=>1,'data'=>$articleModel,'msg'=>'文章内容获取成功'];
    }

    
}