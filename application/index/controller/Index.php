<?php
namespace app\index\controller;


use app\admin\model\ArticleModel;
use app\index\model\MenuModel;

class Index extends ComController
{
    public static $menuModel;
    public static $menus;
    public static $articleModel;
    function __construct() {
        parent::__construct();
        self::$articleModel = new ArticleModel();
        self::$menuModel = new MenuModel();
        self::$menus = self::$menuModel->getMenus(MenuModel::all(),0);
    }
    public function index()
    {
        $article = ArticleModel::get(1);
        return $this->fetch('index',['title'=>'LinkChen的网站','basics'=>self::$menus['0']['parentid'],'content'=>$article['content']]);
    }
}
