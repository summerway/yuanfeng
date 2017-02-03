<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 16/12/24
 * Time: 下午9:04
 */
namespace Board\Controller;

use Board\Model\Config;
use Think\Controller;
use Think\Verify;

/**
 * Class IndexController
 * @package Borad\Controller
 */
class PageController extends Controller {

    /*************** Page **************/
    /**
     * 默认首页
     */
    public function Index(){
        $info = array (
            'Operating System' => PHP_OS,
            'Operating Environment' => $_SERVER ["SERVER_SOFTWARE"],
            'PHP version' => phpversion(),
            'Run PHP' => php_sapi_name (),
            'Mysql version' => mysqli_get_server_info(),
            'ThinkPHP version' => THINK_VERSION,
            'Single-file upload limit' => ini_get ( 'upload_max_filesize' ),
            'Form upload limit' => ini_get ( 'post_max_size' ),
            'Execution time limit' => ini_get ( 'max_execution_time' ) . 'seconds',
            'Server time' => date ( "Y年n月j日 H:i:s" ),
            'Beijing time' => gmdate ( "Y年n月j日 H:i:s", time () + 8 * 3600 ),
            'Server domain name / IP' => $_SERVER ['SERVER_NAME'] . ' [ ' . gethostbyname ( $_SERVER ['SERVER_NAME'] ) . ' ]',
            'remaining space' => round ( (@disk_free_space ( "." ) / (1024 * 1024)), 2 ) . 'M',
            'register_globals' => get_cfg_var ( "register_globals" ) == "1" ? "ON" : "OFF",
            'magic_quotes_gpc' => (1 === get_magic_quotes_gpc ()) ? 'YES' : 'NO',
            'magic_quotes_runtime' => (1 === get_magic_quotes_runtime ()) ? 'YES' : 'NO'
        );
        $this->assign ( 'info', $info );
        $this->display ();
    }

    /**
     * 登录页
     */
    public function login(){
        if (!isset($_SESSION[C('USER_AUTH_KEY')])) {
            $this->assign("title","Back-stage Management - Sign in");
            $this->display();
        } else {
            redirect(U(C('USER_AUTH_GATEWAY')));
        }
    }

    /**
     * 404
     */
    public function errorPage(){
        $this->display();
    }

    /**
     * 日历任务
     */
    public function calendar(){
        $this->assign('title','Calendar Page');
        $this->display();
    }

    /************** Action ************/
    /**
     * 验证码
     */
    public function verify()
    {
        $verify = new Verify(C('VERIFY_CONF'));
        $verify->entry();
    }

    public function checkLogin(){
        $post = I('request.');
        //check verify
        $verify = new Verify();
        if(!$verify->check($post['verify'])){
            $this->ajaxReturn(make_rtn('the verify is wrong!'));
        }

        $auth_info = M('rbac_user')->where(['account'=> $post['account']])->field('id,account,password,session_id,nickname,email')->find();
        if(!$auth_info){
            $this->ajaxReturn(make_rtn('account does not exist!'));
        }else{
            if($cookie = cookie(C('USER_AUTH_KEY'))){
                //cookie login
                if ($cookie['password'] != hash('md5',$auth_info['password'].$auth_info['account'])) {
                    $this->ajaxReturn(make_rtn('the password is invalid!'));
                }
            }else{
                //regular login
                if ($auth_info['password'] != hash('md5',$post['password'])) {
                    $this->ajaxReturn(make_rtn('the password is invalid!'));
                }
            }


            clear_last_session($auth_info['session_id']);
            session(C('USER_AUTH_KEY'),$auth_info['id']);
            session('user_info', filterParams($auth_info,['account','nickname','email']));

            //save login data
            $data = array('id' => $auth_info['id'], 'last_login_time' => time(), 'login_count' => array('exp', 'login_count+1'),
                'last_login_ip' => get_client_ip(), 'session_id' => session_id());

            //save cookie
            if('on' == $post['remember'] || 1 == $post['remember']){
                if(!$cookie)
                    cookie(C('USER_AUTH_KEY'),['account' => $post['account'],'password' => hash('md5',hash('md5',$post['password']).$post['account']),'remember' => $post['remember']],['expire' => 30 * ONE_DAY]);
            }else{
                cookie(C('USER_AUTH_KEY'),null);
            }

            $rs = M('rbac_user')->save($data);
            $this->ajaxReturn(make_url_rtn('login success',U('Index/index')));
        }
    }

    public function ajaxLoginInfo(){
        $info = cookie(C('USER_AUTH_KEY'));
        if($info){
            $this->ajaxReturn(['status' => true,'list' => $info]);
        }else{
            $this->ajaxReturn(make_rtn(Config::NO_DATA));
        }
    }

    public function logout(){
        if (isset($_SESSION[C('USER_AUTH_KEY')])) {
            unset($_SESSION[C('USER_AUTH_KEY')]);
        }
        redirect(U(C('USER_AUTH_GATEWAY')));
    }
}