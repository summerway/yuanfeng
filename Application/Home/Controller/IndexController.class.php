<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 16/12/24
 * Time: 下午9:04
 */
namespace Home\Controller;

use Board\Model\Config;

/**
 * Home Page
 * Class IndexController
 * @package Home\Controller
 */
class IndexController extends CommonController {
    /**
     * Home
     */
    public function index(){
        $this->assign('keywords','');
        $this->assign('description','');
        $this->assign('title','Home Page');
        $this->display();
    }

    /**************Action**********/
    public function ajaxProductCateList(){
        $list = M("products")->group('category')->field('category,image')->select();
        $conf = Config::getProductConf();
        foreach ($list as &$val){
            $val['category_show'] = $conf['category'][$val['category']];
        }

        $this->ajaxReturn(['status' => true,'list' => $list]);
    }

    public function ajaxProductTypeList(){
        $list = M('products')->group('type')->field('type,image')->where(['image'=> ['neq','']])->select();
        $size_conf = Config::getTplConf('PD_SIZE');
        $type_conf = Config::getTplConf('PD_TYPE');

        foreach ($list as &$item){
            $type_products = M('products')->field('id,name,size,code,price_cn,price_kr,image')->where(['type' => $item['type'],'image'=> ['neq','']])
                ->order('create_time desc')->limit(3)->select();

            foreach ($type_products as &$pd){
                $pd['image'] = __ROOT__ ."/Public/Main/image/Products/".$pd['image'];
                $pd['size'] = $pd['size'] > 0 ? '('.$size_conf[$pd['size']].')' : '';
                $pd['price'] = C('LANG') == 'CN' ? $pd['price_cn']."元" : $pd['price_kr']."won";
                $pd['price_img'] = __ROOT__ ."/Public/Main/image/HomePage/" . (C('LANG') == 'CN' ? 'currency_cn.png' : 'currency_kr.gif');
                $pd['link'] = __APP__.'/Home/Product/detailList?id='.$pd['id'];
            }

            $item['type_show'] = $type_conf[$item['type']];
            $item['image'] = __ROOT__ ."/Public/Main/image/Products/" . $item['image'];
            $item['link'] = __APP__.'/Home/Product/index?type='.$item['type'];
            $item['child'] = $type_products;
        }
        $this->ajaxReturn(['status' => true,'list' => $list]);
    }

    public function ajaxNavMenu(){
        $this->ajaxReturn(['status' => true,'list' => Config::getTplConf('PD_CATEGORY')]);
    }

}