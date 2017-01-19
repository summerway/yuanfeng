<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 16/01/2017
 * Time: 3:26 PM
 */

namespace Board\Model;

/**
 * 后台系统配置类
 * Class Config
 * @package Board\Model
 */
class Config{

    const INSERT_COMPLETED = "Insert the data successfully";
    const INSERT_COMPLETED_RETURN =  "Insert the data successfully <br/> return to the list after 2 seconds";
    const INSERT_FAILED = "insert failed";

    const UPDATE_COMPLETED = "Update the data successfully";
    const UPDATE_COMPLETED_RETURN = "Update the data successfully <br/> return to the list after 2 seconds";
    const UPDATE_FAILED = "update failed";

    static function getProductConf(){
        $item = ['size','category','type'];
        $conf = [];
        foreach ($item as $val){
            $item_conf = C(strtoupper($val));
            $conf[$val] = $item_conf;
        }
        return $conf;
    }

}