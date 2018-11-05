<?php
/**
 * Created by PhpStorm.
 * User: cl
 * Date: 2018/11/1
 * Time: 16:37
 */

namespace app\index\model;


use think\Model;

class MenuModel extends Model
{
    protected $name = 'menu';

    public function getMenus($data, $parentId){
        $tree = array();
        foreach($data as $k => $v){
            if($v['parentid'] == $parentId){
                $v['parentid'] = $this->getMenus($data, $v['id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }
}