<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 17/01/06
 * Time: 下午3:57
 */
namespace Board\Controller;

/**
 * 产品类
 * Class ProductsController
 * @package Board\Controller
 */
class ProductsController extends CommonController {
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