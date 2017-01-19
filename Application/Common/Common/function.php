<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 16/12/25
 * Time: 下午11:41
 */


/**
 * 生成ajax返回数组
 * @param string $info 弹出消息
 * @param boolean $status 返回结果
 * @param string $url 跳转地址
 * @param string $act 动作
 * @return array
 */
function make_rtn ($info, $status = false, $url = '', $act = '')
{
    $rtn = array('status' => $status, 'info' => $info, 'url' => $url, 'act' => $act);
    return $rtn;
}

/**
 * 生成ajax返回数组
 * @param $info
 * @param null $url
 * @return array
 */
function make_url_rtn ($info, $url = null)
{
    if (empty($url)) {
        $url = __CONTROLLER__ . '/index' . $_SESSION[C('SEARCH_PARAMS_STR')];
    }
    $rtn = array('status' => true, 'info' => $info, 'url' => $url);
    return $rtn;
}

/**
 * 兼容前端入参 判断是否是时间戳
 * @param string $str
 * @return bool
 */
function isTimeStamp($str){
    if(strpos($str,'-') !== false || strpos($str,'/') !== false ){
        return false;
    }else{
        return true;
    }
}

/**
 * 兼容前端入参 强行转时间戳
 * @param $str
 * @param bool|false $filterEmpty
 * @return int
 */
function mustTimestamp($str,$filterEmpty = false){
    if($filterEmpty && empty($str)) return 0;
    if(isTimeStamp($str)){
        return $str-'';
    }else{
        return strtotime($str);
    }
}

/**
 * 时间区间生成查询条件
 * @param string $from 起始时间
 * @param string $to   结束时间
 * @param string $time_field 字段
 * @param bool|true $add_one_day 是否需要多加一天
 * @return array
 */
function timeRangeConvertCondition($from,$to,$time_field,$add_one_day = true){
    $condition = [];
    if ($from) {
        if ($to) {
            $condition[$time_field] = ['between', [mustTimestamp($from), $add_one_day ? mustTimestamp($to) + ONE_DAY - 1 : mustTimestamp($to) ]];
        } else {
            $condition[$time_field] = ['egt', mustTimestamp($from)];
        }
    } elseif ($to) {
        $condition[$time_field] = ['elt', $add_one_day ? mustTimestamp($to) + ONE_DAY - 1 : mustTimestamp($to)];
    }
    return $condition;
}

/**
 * 参数过滤
 * @param array $params 原参数数组
 * @param array $keys 需要的参数key数组
 * @param bool|true $ignoreEmpty 是否过滤掉空参数
 * @return array
 */
function filterParams($params, $keys, $ignoreEmpty = true)
{
    $params = array_intersect_key($params, array_fill_keys($keys, 0));
    if ($ignoreEmpty) {
        //过滤空参数
        foreach ($params as $key => $v) {
            if (empty($v)) unset($params[$key]);
        }
    }

    return $params;
}

/**
 * 字符串是否包含指定字符串
 * @param $haystack
 * @param $needle
 * @return bool
 */
function str_exists($haystack, $needle)
{
    if(!is_array($needle)){
        $needle = explode(',',$needle);
    }
    foreach($needle as $str){
        if(strpos($haystack, $str))
            return true;
    }
    return false;
}

/**
 * 反推位运算
 * @param $param
 * @return array
 */
function trackBit($param){
    $base = 1;
    $result = [];
    while($param + 1 > $base){
        $result[] = $param & $base;
        $base *= 2;
    }
    return array_filter($result,function($v){return $v !== 0;});
}

/**
* 取数组中的最小值(保存键值,返回数组)
* @param $arr
* @return array
 */
function min_array($arr){
    if(!is_array($arr)){
        return [$arr];
    }
    $min_keys = array_keys($arr,min($arr));

    $data = [];
    foreach($min_keys as $key){
        $data[$key] = $arr[$key];
    }
    return $data;
}

/**
 * 取数组中的最大值(保存键值,返回数组)
 * @param $arr
 * @return array
 */
function max_array($arr)
{
    if (!is_array($arr)) {
        return [$arr];
    }
    $max_keys = array_keys($arr, max($arr));

    $data = [];
    foreach ($max_keys as $key) {
        $data[$key] = $arr[$key];
    }
    return $data;
}

/**
 * 多维数组求和
 * @param $array
 * @return int
 */
function get_sum($array) {
    $num = 0;
    foreach($array as $k => $v) {
        if(is_array($v)) {
            $num += get_sum($v);
        }
    }
    return $num + array_sum($array);
}

/**
 * 账号登录唯一性
 * @param string $session_to_del 需要被踢掉的session
 */
function clear_last_session ($session_to_del)
{
    $current_session_id = session_id();
    session_id($session_to_del);
    session_destroy();
    session_id($current_session_id);
    session_start();
}