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
class PageController extends CommonController {
    /**
     * 默认首页
     */
    public function index(){
        $this->display();
    }

    /**
     * 404
     */
    public function errorPage(){
        $this->display();
    }
}