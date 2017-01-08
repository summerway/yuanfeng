<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 16/12/24
 * Time: 下午9:04
 */
namespace Home\Controller;

/**
 * Home Page
 * Class IndexController
 * @package Home\Controller
 */
class IndexController extends CommonController {
    /**
     * Home
     */
    public function index(){
        $this->assign('keywords','');
        $this->assign('description','');
        $this->assign('title','Home Page');
        //$this->assign('isHome',1);
        $this->display();
    }
}