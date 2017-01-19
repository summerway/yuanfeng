<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 17/01/06
 * Time: 下午3:57
 */
namespace Board\Controller;

use Board\Model\Config;

/**
 * 产品类
 * Class ProductsController
 * @package Board\Controller
 */
class ProductController extends CommonController {

    const TABLE = 'products';
    
    /**************Page***********/
    /**
     * list
     */
    public function index(){
        $this->display();
    }

    public function add(){
        $this->display();
    }

    public function edit(){
        $this->display();
    }

    /*************Ajax Action*************/

    public function dataList(){
        $request = I('request.');

        $page = $request['page']  ? $request['page'] -1 : 0;
        $listRows = $request['listRows'];

        $mdl = M(self::TABLE);
        $tb_fields = $mdl->getDbFields();
        $condition = filterParams($request,$tb_fields);

        $totalRows = $mdl->where($condition)->count('id');
        $list = $mdl->where($condition)->limit($page.",".$listRows)->select();
        $conf = Config::getProductConf();

        //convert data
        foreach ($list as &$val) {
            $val['image'] = $val['image'] ?  __ROOT__ ."/Public/Main/image/Products/" . $val['image'] : __ROOT__ ."/Public/Main/image/" . "no-img-gallery.png";
            $val['type'] = $conf['type'][$val['type']];
            $val['category'] = $conf['category'][$val['category']];
            $val['size'] = $conf['size'][$val['size']];
        }

        $this->ajaxReturn(array('status'=>true,'list'=>$list ? : false,'max_page'=> ceil($totalRows / $listRows)));
    }

    public function ajaxProductInfo(){
        $id = I('request.id');
        $record = M(self::TABLE)->find($id);
        if($record){
            //convert data
            if($record['image']){
                $product_image['preview'] = __ROOT__.'/Public/Main/image/Products/'.$record['image'];
                $size = filesize('Public/Main/image/Products/'.$record['image']);
                $product_image['config'] = [[
                    'caption'=> $record['image'],
                    'width' => '120px',
                    'url' => __APP__."/Board/Upload/removePic",
                    'size' => $size,
                    'extra' => [
                        'folder' => 'Products',
                        'name' => $record['image']
                    ]]
                ];
                $record['image'] = $product_image;
            }else{
                $record['image'] = [];
            }

            $detail_list = M('product_img')->where(['product_id'=> $id])->getField('image',true);
            $detail_img = [];
            if($detail_list){
                foreach ($detail_list as $img){
                    $url = __ROOT__.'/Public/Main/image/Products/'.$img;
                    $size = filesize('Public/Main/image/Products/'.$img);
                    $detail_img['preview'][] = $url;
                    $detail_img['config'][] = [
                        'caption'=> $img,
                        'width' => '120px',
                        'url' => __APP__."/Board/Upload/removePic",
                        'size' => $size,
                        'extra' => [
                            'folder' => 'Products',
                            'name' => $img
                        ]
                    ];
                }
                $record['detail_img'] = $detail_img;
            }else{
                $record['detail_img'] = [];
            }

            $this->ajaxReturn(array('status'=> true,'list'=> $record));
        }else{
            $this->ajaxReturn(make_rtn('no match data'));
        }
    }

    public function insert(){
        $request = I('request.');

        $mdl = M(self::TABLE);
        $tb_fields = $mdl->getDbFields();

        $insert = filterParams($request,$tb_fields);
        //default param
        $insert['create_time'] = time();

        $new_id = $mdl->add($insert);
        if($new_id > 0){
            if($request['detail_img']){
                $img_list = [];
                foreach ($request['detail_img'] as $img){
                    $img_list[] = [
                        'product_id' => $new_id,
                        'image' => $img
                    ];
                }
                M('product_img')->addAll($img_list);
            }
            $this->ajaxReturn(make_url_rtn(Config::INSERT_COMPLETED_RETURN));
        }else {
            $this->ajaxReturn(make_rtn(Config::INSERT_FAILED));
        }
    }

    public function changeStatus(){
        $request = I('request.');
        $data = filterParams($request,['id','status']);
        $rs = M(self::TABLE)->save($data);
        if($rs !== false ){
            $this->ajaxReturn(['status' => true]);
        }else {
            $this->ajaxReturn(make_rtn(Config::UPDATE_FAILED));
        }
    }

    public function update(){
        $request = I('request.');

        $mdl = M(self::TABLE);

        $tb_fields = $mdl->getDbFields();
        $data = filterParams($request,$tb_fields);
        $rs = $mdl->save($data);
        if($rs !== false ){
            $this->ajaxReturn(make_url_rtn(Config::UPDATE_COMPLETED_RETURN));
        }else {
            $this->ajaxReturn(make_rtn(Config::UPDATE_FAILED));
        }
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