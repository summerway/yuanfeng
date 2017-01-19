<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 16/01/2017
 * Time: 10:01 AM
 */


namespace Board\Controller;

use Think\Controller;

/**
 * Class EmptyController
 * @package Board\Controller
 */
class EmptyController extends Controller {

    /**
     * 空操作
     * @param $name
     */
    public function _empty($name)
    {
        header("HTTP/1.0 404 Not Found");
        $this->display('Page:errorPage');
    }
}