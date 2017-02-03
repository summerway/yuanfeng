<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 17/1/18
 * Time: 下午9:09
 */

namespace Home\Controller;

use Board\Model\Config;

/**
 * product list
 * Class ProductController
 * @package Home\Controller
 */
class ProductController extends CommonController
{
    /************ Page *************/
    /**
     * 分类列表页
     */
    public function index(){
        $request = I('request.');

        $param = current(array_keys($request));
        $conf = Config::getTplConf('pd_'.$param);

        if(C('LANG') == 'CN'){
            $field = ['category' => '产品分类','type' => '产品类型'];
            session('path_map','▶ 首页 > '.$field[$param].' > '.$conf[$request[$param]]);
        }else{
            session('path_map','▶ Home > Products by'.$param.' > '.$conf[$request[$param]]);
        }

        $this->assign('title', 'product List');
        $this->display();
    }

    /**
     * 产品详情页
     */
    public function detailList(){
        $this->display();
    }

    /**
     * 产品索引页
     */
    public function search(){
        $display = C('LANG') == 'CN' ?  ACTION_NAME .'_cn' : ACTION_NAME;
        $this->display($display);
    }

    /************ Action *************/

    public function searchList(){
        $request = I('request.');

        $page = $request['page']  ? $request['page'] -1 : 0;
        $listRows = $request['listRows'];

        $mdl = M('products');
        $tb_fields = $mdl->getDbFields();
        $condition = filterParams($request,$tb_fields);
        if(isset($request['keyword']) && count($request['keyword']) > 0){
            $condition['_string'] = " name like '%".$request['keyword']."%' ".
                " or code like '%". $request['keyword'] ."%'";
        }

        $totalRows = $mdl->where($condition)->count('id');
        $list = $mdl->where($condition)->limit($page.",".$listRows)->select();
        $conf = Config::getProductConf();

        //convert data
        foreach ($list as &$val) {
            $val['image'] = $val['image'] ?  __ROOT__ ."/Public/Main/image/Products/" . $val['image'] : __ROOT__ ."/Public/Main/image/" . "no-img-gallery.png";
            $val['type'] = $conf['type'][$val['type']];
            $val['category'] = $conf['category'][$val['category']];
            $val['size'] = $conf['size'][$val['size']] ? : "";
        }

        $this->ajaxReturn(array('status'=>true,'list'=>$list ? : false,'max_page'=> ceil($totalRows / $listRows)));
    }

    public function dataList()
    {
        $request = I('request.');

        $page = $request['page']  ? $request['page'] -1 : 0;
        $listRows = 20;

        $mdl = M('products');
        $tb_fields = $mdl->getDbFields();
        $condition = filterParams($request,$tb_fields);
        $condition['status'] = 1; //status active

        $totalRows = $mdl->where($condition)->count('id');
        $list = $mdl->where($condition)->limit($page.",".$listRows)->select();
        if($list){
            $size_conf = Config::getTplConf('PD_SIZE');

            //convert data
            foreach ($list as &$val) {
                $val['image'] = $val['image'] ?  __ROOT__ ."/Public/Main/image/Products/" . $val['image'] : __ROOT__ ."/Public/Main/image/" . "no-img-gallery.png";
                $val['size'] = $val['size'] ? '('.$size_conf[$val['size']].')' : '';
                $val['price'] = C('LANG') == 'CN' ? "&yen;<strong>".$val['price_cn']."</strong>元" : "&#8361;<strong>".$val['price_kr']."</strong>won";
                $val['detail_url'] = __CONTROLLER__.'/detailList?id='.$val['id'];
            }

            $this->ajaxReturn(array('status'=>true,'list'=>$list,'max_page'=> ceil($totalRows / $listRows)));
        }else{
            $this->ajaxReturn(make_rtn(Config::NO_DATA));
        }
    }

    public function ajaxProductBaseInfo(){
        $request = I('request.');
        $data = M('products')->field('image,name,size,code,price_cn,price_kr,manufacturer,origin')
            ->where(['status' => 1,'id' => $request['id']])->find();

        //data convert
        if($data){
            $size_conf = Config::getTplConf('PD_SIZE');
            $data['image'] = $data['image'] ?  __ROOT__ ."/Public/Main/image/Products/" . $data['image'] : __ROOT__ ."/Public/Main/image/" . "no-img-gallery.png";
            $data['size'] = $data['size'] ? '('.$size_conf[$data['size']].')' : '';
            $data['price'] = C('LANG') == 'CN' ? "价格：&yen; ".$data['price_cn']."元" : "Price：&#8361; ".$data['price_kr']."won";
            $data['code'] = (C('LANG') == 'CN' ? '产品编号：' : 'code：' ).$data['code'] ;
            $data['manufacturer'] = (C('LANG') == 'CN' ? '生产厂商：' : 'manufacturer：' ).$data['manufacturer'];
            $data['origin'] = (C('LANG') == 'CN' ? '原产地：' : 'origin：' ). $data['origin'];
            $this->ajaxReturn(array('status'=>true,'list'=> $data ));
        }else{
            $this->ajaxReturn(make_rtn(Config::NO_DATA));
        }
    }

    public function ajaxProductDescInfo(){
        $images = M('product_img')->where(['product_id' => I('request.id')])->field('concat(\''. __ROOT__ ."/Public/Main/image/Details/" .'\',image) as image')->select();
        if($images){
            $this->ajaxReturn(array('status'=> true,'list'=> $images ));
        }else{
            $this->ajaxReturn(make_rtn(Config::NO_DATA));
        }
    }

    public function ajaxRelationProduct(){
        $product_id = I('request.id');

        $property = M('products')->field('type,category')->find($product_id);
        $condition = [
            'id' => ['neq',$product_id],
            '_string' => " type = {$property['type']} or category = {$property['category']}"
        ];
        $relation_list = M("products")->where($condition)->field('id,name,code,price_cn,price_kr,image')->order(" rand() ")->limit(6)->select();

        //data convert
        if($relation_list){
            foreach($relation_list as &$val){
                $val['price'] =  C('LANG') == 'CN' ? "价格: &yen;<strong>".$val['price_cn']."</strong>元" : "Price: &#8361;<strong>".$val['price_kr']."</strong>won";
                $val['code'] = (C('LANG') == 'CN' ? '产品编号: ' : 'code: ' ) . $val['code'];
                $val['detail_url'] = __CONTROLLER__.'/detailList?id='.$val['id'];
                $val['image_url'] = $val['image'] ?  __ROOT__ ."/Public/Main/image/Products/" . $val['image'] : __ROOT__ ."/Public/Main/image/" . "no-img-gallery.png";

            }
            $this->ajaxReturn(array('status'=> true,'list'=> $relation_list ,'title' => C('LANG') == 'CN' ? '相关产品' : 'Relation Product'));
        }else{
            $this->ajaxReturn(make_rtn(Config::NO_DATA));
        }
    }

    public function ajaxPathMap(){
        $this->ajaxReturn(['status' => true,'list' => session('path_map')]);
    }

    /**
     * 配置传参
     * @return array
     */
    public function ajaxConf(){
        $conf = Config::getProductConf();
        $this->ajaxReturn(['status' => true,'list' => $conf]);
    }
}