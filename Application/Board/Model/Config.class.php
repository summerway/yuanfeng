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

    const NO_DATA = "No matching records found";

    static function getProductConf(){
        $item = ['size','category','type'];
        $conf = [];
        $prefix = 'PD_';
        switch (strtolower(C('LANG'))){
            case 'en':
                $suffix = '';
                break;
            default:
                $suffix = "_".strtoupper(C("LANG"));
                break;
        }

        foreach ($item as $val){
            $item_conf = C(strtoupper($prefix.$val.$suffix));
            $conf[$val] = $item_conf;
        }
        return $conf;
    }

    static function getTplConf($key){
        switch (strtolower(C('LANG'))){
            case 'en':
                $config = C(strtoupper($key)) ? : [];
                break;
            default:
                $key_str = strtoupper($key)."_".strtoupper(C("LANG"));
                $config = C($key_str) ? : [];
                break;
        }

        return $config;
    }

}