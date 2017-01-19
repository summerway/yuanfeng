<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 16/12/24
 * Time: 下午9:04
 */
namespace Board\Controller;

/**
 * Class IndexController
 * @package Borad\Controller
 */
class IndexController extends CommonController {

    /*************Page************/
    /**
     * 首页
     */
    public function index(){
        $this->assign("title","Home Page");
        $this->display();
    }
}