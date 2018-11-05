<?php
/**
 * Created by PhpStorm.
 * User: parallels
 * Date: 10/25/18
 * Time: 11:11 AM
 */

namespace app\admin\controller;

use app\admin\model\MenuModel;

class Menu extends ComController
{
    public static $menuModel;

    function __construct() {
        parent::__construct();
        self::$menuModel = new MenuModel();
    }

    public function getMenus(){
        $list = self::$menuModel->getMenus();
        return ['code'=>0,'msg'=>'数据获取成功!','count'=>count($list),'data'=>$list];
    }

    /**
     * @return array
     * @throws \think\exception\DbException
     */
    public function addMenu(){
        return ['code'=>self::$menuModel->saveMenu(input('post.displayname/s'),input('post.parentid/d'))];
    }

    /**
     * @return array
     */
    public function renameMenu(){
        return ['code'=>self::$menuModel->renameMenu(input('post.id/d'),input('post.displayname/s'))];
    }

    public function getMenusByLimit(){
        $page = input('get.page/d');
        $limit = input('get.limit/d');
        $list = self::$menuModel->getMenusByLimit($limit,$page - 1);
        return ['code'=>0,'msg'=>'数据获取成功!','count'=>self::$menuModel->count(),'data'=>$list];
    }
}