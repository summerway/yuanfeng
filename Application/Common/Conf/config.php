<?php

// 时区
date_default_timezone_set('Asia/Shanghai');

return array(
    //thinkphp 异常类替换
    'TMPL_EXCEPTION_FILE' => LIB_PATH . 'Vendor/think_exception.php',

    'LOAD_EXT_CONFIG' => 'config,db,user,product',


    'UPLOAD_DIR' => 'Public/Upload/', //上传文件路径（后台使用）

    'TMPL_PARSE_STRING' => array(
        '__JS__'    => __ROOT__.'/Public/Common/js', //Js Path
        '__CSS__'   => __ROOT__.'/Public/Common/css', //Css Path
        '__IMG__'   => __ROOT__.'/Public/Main/image', //Image Path
        '__VD__'   => __ROOT__.'/Public/Vendor', //Vendor Path
        '__UP__'    => __ROOT__.'/Public/Upload', //Upload Path
        '__DOWN__'  => __ROOT__.'/Public/Download', //Download Path
    ),

    'MODULE_ALLOW_LIST' => array( // 允许访问模块列表
        'Board',
        'Home',
    ),

    'DEFAULT_MODULE' => 'Home', // 默认模块

    'URL_MODEL' => 2, // 0 (普通模式); 1 (PathInfo 模式); 2 (Rewrite 模式); 3 (兼容模式)默认为PathInfo 模式，提供最好的用户体验和SEO支持
    'URL_HTML_SUFFIX' => '', // URL伪静态后缀设置，

    'USER_AUTH_GATEWAY' => 'Page/login', // 默认认证网关
    'USER_AUTH_KEY' => 'auth_id', // 用户认证SESSION标记
);