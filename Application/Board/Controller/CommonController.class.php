<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 17/01/04
 * Time: 下午1:34
 */

namespace Board\Controller;

use Think\Controller;

/**
 * Class CommonController
 * @package Board\Controller
 */
class CommonController extends Controller {

    /**
     * 空操作
     * @param $name
     */
    public function _empty($name)
    {
        header("HTTP/1.0 404 Not Found");
        $this->display('Page:errorPage');
        //$this->error('无此操作：' . $name, PHP_FILE . C('USER_AUTH_GATEWAY'));
    }

    public  function _initialize(){
        if (!isset ($_SESSION [C('USER_AUTH_KEY')])) {
            redirect(U(C('USER_AUTH_GATEWAY')));
        }
    }

    public function add(){
        $this->display();
    }

    public function edit(){
        $vo = M(CONTROLLER_NAME)->find(I('request.id'));
        $this->assign('vo', $vo);
        $this->display();
    }

}