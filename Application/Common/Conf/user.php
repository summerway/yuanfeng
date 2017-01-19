<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 16/2/21
 * Time: 下午2:48
 */

/**
 * 常量定义
 */
const ONE_DAY = 86400;    // 1天的时间戳数值
const ONE_HOUR = 3600;      // 1小时时间戳数值

return array(
    //page
    'VAR_PAGE' => 'p',

    'NAV_PREFIX' => 'nav-',

    //verify
    'VERIFY_CONF' => [
        'fontSize' => 14,       // 验证码字体大小
        'length' => 4,          // 验证码位数
        'imageH' => 34,         // 验证码高度
        'userImgBg' => true,    // 开启验证码背景
        'useNoise' => false     // 关闭验证码干扰杂点
    ]

);
?>