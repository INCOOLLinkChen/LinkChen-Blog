<?php
/**
 * Created by PhpStorm.
 * User: parallels
 * Date: 10/25/18
 * Time: 4:54 PM
 */

namespace app\admin\controller;


use app\admin\model\IpInfo;
use app\admin\model\LogModel;
use think\Controller;

class ComController extends Controller
{

    protected $beforeActionList = [
        'addLog',
    ];

    protected function addLog(){
        $logModel = new LogModel();
        $ip = get_real_ip();
        $logModel->clientip = ip2long($ip);
        $ipInfo = IpInfo::get(['ip' => $logModel->clientip]);
        $logModel->action = $_SERVER['REQUEST_URI'];
        if($ipInfo){
            $logModel->province = $ipInfo->province;
            $logModel->city = $ipInfo->city;
        }else{
            $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
            $ipobj = json_decode(getMethod($url));
            if($ipobj){
                $logModel->province = $ipobj->data->region;
                $logModel->city = $ipobj->data->city;
                $ipInfo = new IpInfo();
                $ipInfo->ip = $logModel->clientip;
                $ipInfo->province = $logModel->province;
                $ipInfo->city = $logModel->city;
                $ipInfo->save();
            }
        }
        $logModel->save();
    }
}