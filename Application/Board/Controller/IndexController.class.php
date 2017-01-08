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
    /**
     * 首页
     */
    public function index(){
        /*if (! isset ( $_SESSION [C ( 'USER_AUTH_KEY' )] )) {
            redirect ( PHP_FILE . C ( 'USER_AUTH_GATEWAY' ) );
        }*/

        if (! isset ( $_SESSION ['bg'] ['menuNow'] )) {
            //
            $_SESSION ['bg'] ['menuNow'] = 'Page';
        }
        $this->assign ( 'menuNow', $_SESSION ['bg'] ['menuNow'] ); // 默认菜单

        $this->display();
    }

    public function login(){
        $this->display();
    }
}