<?php
/**
 * Created by PhpStorm.
 * User: summerway
 * Date: 16/2/21
 * Time: 下午9:09
 */
namespace Home\Controller;

/**
 * 产品介绍
 * Class ProductController
 * @package Home\Controller
 */
class ProductController extends CommonController
{
    /**
     * 首页
     */
    public function index()
    {
        //提取左侧导航菜单数据
        $cate_mdl = M('ProductsCategory');
        $list = $cate_mdl->where('level = 0')->getField('id,name',true);

        $data = array();
        foreach($list as $key => $val){
            $children = $cate_mdl->where('parent_id =%d',$key)->getField('id,name',true);
            $data[$key]['id'] = $key;
            $data[$key]['name'] = $val;
            $data[$key]['children'] = $children;
        }

        $this->assign('nav',$data);
        $this->assign('title', '产品介绍-宁波江东增拓贸易有限公司');

        $this->assign('keywords','宁波脚轮 环球脚轮 江东增拓有限公司 万向轮 液压车 平板车 脚杯 增拓官网');
        $this->assign('description','宁波江东增拓贸易有限公司是宁波脚轮专业供应商、环球脚轮驻宁波办事处，主要经营万向轮、液压车、平板车、脚杯、不锈钢脚杯。');
        $this->display();
    }

    /**
     * 产品列表
     */
    public function productList(){
        $get = I('get.');

        $condition = array();
        if(!empty($get['cate'])){
            $cate = M('ProductsCategory')->where('parent_id = %d',$get['cate'])->getField('id',true);
            $condition = array(
                'category' => array('in',$cate)
            );
        }

        if(!empty($get['type'])){
            $condition['category'] = $get['type'];
        }

        $pdt_info_mdl = M('ProductsInfo');
        $count = $pdt_info_mdl->where($condition)->count();
        $p = new \Org\Util\Page($count,8);
        $p->setConfig('header', '种脚轮');
        $p->setConfig('prev', "<");
        $p->setConfig('next', '>');
        $p->setConfig('first', '<<');
        $p->setConfig('last', '>>');
        $page=$p->show();

        $data = $pdt_info_mdl->where($condition)->limit($p->firstRow.','.$p->listRows)->select();
        $this->assign('page', $page);
        $this->assign('products',$data);

        $this->display('show');

    }

}