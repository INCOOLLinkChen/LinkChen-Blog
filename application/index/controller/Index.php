<?php
namespace app\index\controller;


use app\index\model\MenuModel;

class Index extends ComController
{
    public static $menuModel;
    public static $menus;
    function __construct() {
        parent::__construct();
        self::$menuModel = new MenuModel();
        self::$menus = self::$menuModel->getMenus(MenuModel::all(),0);
    }
    public function index()
    {
        return $this->fetch('index',['title'=>'LinkChen的网站','basics'=>self::$menus['0']['parentid']]);
    }
}
