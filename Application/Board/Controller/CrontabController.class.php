<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 16/01/2017
 * Time: 6:10 PM
 */

namespace Board\Controller;

/**
 * 定时任务类
 * Class CrontabController
 * @package Borad\Controller
 */
class CrontabController extends CommonController {

    //清楚多余无效图片
    public function removeInvalidImage(){
        $dir_name = UploadController::IMG_PATH."Products/";

        //打开目录
        $dir = opendir($dir_name);
        $count = 0;
        //循环读取目录里的内容
        while($filename = readdir($dir)){
            if($filename != "." && $filename != ".."){
                $file = $dir_name."/".$filename;
                if(!is_dir($file) ) {
                    $valid_file = M('products')->where(['image'=> $filename])->find();
                    if(!$valid_file){
                        $rs = unlink($file);
                        if($rs){
                            $count ++;
                        }
                    }
                }
            }
        }

        echo 'Deleted '.$count.' invalid files';
    }
}