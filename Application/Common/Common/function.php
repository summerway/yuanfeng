<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 16/12/25
 * Time: 下午11:41
 */


/**
 * 生成ajax返回数组
 * @param string $info 弹出消息
 * @param boolean $status 返回结果
 * @param string $url 跳转地址
 * @param string $act 动作
 * @return array
 */
function make_rtn ($info, $status = false, $url = '', $act = '')
{
    $rtn = array('status' => $status, 'info' => $info, 'url' => $url, 'act' => $act);
    return $rtn;
}