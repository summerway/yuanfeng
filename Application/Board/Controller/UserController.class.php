<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 17/01/05
 * Time: 下午2:34
 */
namespace Board\Controller;

/**
 * Class IndexController
 * @package Borad\Controller
 */
class UserController extends CommonController {
    /**
     * list
     */
    public function index(){
        $_SESSION ['bg'] ['menuNow'] = CONTROLLER_NAME;
        $this->display();
    }

    public function insert(){
        $this->display();
    }

    public function edit(){
        $this->display();
    }

}