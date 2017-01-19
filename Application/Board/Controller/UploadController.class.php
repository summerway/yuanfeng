<?php
/**
 * Created by PhpStorm.
 * User: summerway
 * Date: 13/01/2017
 * Time: 4:39 PM
 */

namespace Board\Controller;

use Org\Util\UploadFile;

class UploadController extends CommonController{

    const IMG_PATH = 'Public/Main/image/';
    const MAX_SIZE = 10485760;  //上传文件大小（10M）

    public function uploadPic()
    {
        $upload = new UploadFile();

        //设置上传文件大小
        $upload->maxSize = MAX_SIZE;
        // 设置上传文件类型
        $upload->allowExts =  ['jpg', 'gif', 'png', 'jpeg'];
        // 禁止自动使用子目录
        $upload->autoSub = false;
        // 上传文件的保存规则
        $upload->saveRule =  'uniqid';
        //保存路径
        $subPath = $_REQUEST['folder'] ? $_REQUEST['folder'].'/' : "";
        $upload->savePath = self::IMG_PATH.$subPath;

        if (!$upload->upload()) {
            // exception
            $this->ajaxReturn(make_rtn($upload->getErrorMsg()));
        } else {
            $info= $upload->getUploadFileInfo();
            $this->ajaxReturn(['status'=> true,'data' => $info]);
        }
    }

    public function removePic(){
        $request = $_REQUEST;
        $filename = self::IMG_PATH.$request['folder']."/".$request['name'];
        if(false !== strpos(strtolower($request['folder']),"product")){
            M('products')->where(['image'=> $request['name']])->setField('image',"");
        }
        if(file_exists($filename)){
            $rs = unlink($filename);
            if($rs)
                $this->ajaxReturn(make_rtn("origin image successfully removed",true));
            else
                $this->ajaxReturn(make_rtn("remove failed"));
        }
        $this->ajaxReturn(make_rtn($filename.' is not a valid file path'));
    }
}