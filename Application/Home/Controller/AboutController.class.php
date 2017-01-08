<?php
/**
 * Created by PhpStorm.
 * User: summerway
 * Date: 16/2/21
 * Time: 下午9:04
 */
namespace Home\Controller;

/**
 * 关于我们
 * Class AboutController
 * @package Home\Controller
 */
class AboutController extends CommonController
{
    public function index()
    {
        $this->assign('title', '公司简介-宁波江东增拓贸易有限公司');

        $this->assign('keywords','宁波脚轮 环球脚轮 江东增拓有限公司 万向轮 液压车 平板车 脚杯 增拓官网');
        $this->assign('description','宁波江东增拓贸易有限公司是宁波脚轮专业供应商、环球脚轮驻宁波办事处，主要经营万向轮、液压车、平板车、脚杯、不锈钢脚杯。');
        $this->display();

    }
}