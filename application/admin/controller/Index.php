<?php
namespace app\admin\controller;

use app\admin\model\MenuModel;
use app\admin\model\ArticleModel;

class Index extends ComController
{
    public static $menu;
    public static $articleModel;

    function __construct() {
        parent::__construct();
        self::$menu = new MenuModel();
        self::$articleModel = new ArticleModel();
    }
    public function index() {
        $timedate = date("Y-m-d",time());
        $menus = self::$menu->getMenus();
        //获取最近操作过的文章前20篇
        $articles = self::$articleModel->limit(20)->order('updatetime','desc')->column('id,title,updatetime');
        return $this->fetch('index',['title'=>'LinkChen的网站','timedate'=>$timedate,'menus'=>$menus,'defaultmenuid'=>1,'articles'=>$articles]);
    }
}
