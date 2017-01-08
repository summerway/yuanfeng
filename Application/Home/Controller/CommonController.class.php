<?php
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller {

    protected  function _initialize(){
        //init
    }

    public function verify(){
        $type = 'gif';
        \Org\Util\Image::buildImageVerify(4, 1, $type, 48, 25, 'loginverify');
    }

    /**
     * 访问量统计
     */
    public function accessStatistics(){

    }
}