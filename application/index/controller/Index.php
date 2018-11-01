<?php
namespace app\index\controller;


class Index extends ComController
{
    public function index()
    {
        return $this->fetch('index',['title'=>'LinkChen的网站']);
    }
}
