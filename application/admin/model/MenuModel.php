<?php
/**
 * Created by PhpStorm.
 * User: parallels
 * Date: 10/23/18
 * Time: 11:28 AM
 */
namespace app\admin\model;

use think\Model;

class MenuModel extends Model {

    protected $name = 'menu';

    /**
     * 获取全部菜单
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMenus(){
        $list = self::select();
        foreach ($list as $k=>$v){
            $pathStr = '/';
            if(intval($v['parentid']) == 0){
                $list[$k]['parentName'] = '顶级菜单';
            }else{
                $menu = self::get(intval($v['parentid']));
                $list[$k]['parentName'] = $menu['displayname'];
                $pathArr = explode('/',$v['path']);
                $count = count($pathArr);
                for ($i = 1;$i < $count - 1; $i++){
                    $menu = self::get(intval($pathArr[$i]));
                    $pathStr = $pathStr.$menu['displayname'].'/';
                }
                $pathStr = $pathStr.$list[$k]['displayname'];

            }
            $list[$k]['pathStr'] = $pathStr;
        }
        return $list;
    }

    /**
     * @param $displayname
     * @param $parentid
     * @return false|int
     * @throws \think\exception\DbException
     */
    public function saveMenu($displayname,$parentid){
        $menu = MenuModel::get(intval($parentid));
        if($menu){
            $data['displayname'] = $displayname;
            $data['parentid'] = $parentid;
            $data['path'] = $menu['path'].$menu['id'].'/';
            return $this->save($data);
        }
        return 0;
    }

    /**
     * @param $id
     * @param $displayname
     * @return MenuModel
     */
    public function renameMenu($id,$displayname){
        $data['displayname'] = $displayname;
        $data['id'] = $id;
        return $this->update($data);
    }
}