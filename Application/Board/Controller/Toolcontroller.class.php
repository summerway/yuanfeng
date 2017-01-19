<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 17/01/2017
 * Time: 9:23 AM
 */

namespace Board\Controller;

/**
 * 工具类
 * Class CrontabController
 * @package Borad\Controller
 */
class ToolController extends CommonController {


    /**
     * 服务器时间接口
     */
    public function getTime(){
        $r = array(
            'today' => strtotime('today'),
            'today_show' => date('Y-m-d'),
            'year' => date('Y'),
            'month' => date('m'),
            'day' => date('d'),
            'time_now' => time(),
            'time_now_show' => date('Y-m-d H:i:s',time()),
            'days_end_month' => date('t')-date('d')
        );
        $this->ajaxReturn(make_rtn_crm_success($r));
    }

    /**
     * 接口测试
     */
    public function test(){

    }
}