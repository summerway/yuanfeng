<?php
/**
 * Created by PhpStorm.
 * User: Maple.Xia
 * Date: 17/01/05
 * Time: 下午2:34
 */

namespace Board\Controller;

use Board\Model\Config;

/**
 * Class IndexController
 * @package Borad\Controller
 */
class UserController extends CommonController {

    const TABLE = 'rbac_user';

    /**************Page***********/
    /**
     * list
     */
    public function index(){
        $this->display();
    }

    public function edit(){
        $vo = M(self::TABLE)->find(I('request.id'));
        $this->assign('vo', $vo);
        $this->display();
    }

    public function personInfo(){
        $vo = M(self::TABLE)->find(session(C('USER_AUTH_KEY')));
        $this->assign('vo', $vo);
        $this->display();
    }


    /*************Ajax Action*************/

    public function getUsers(){
        $user_list = M(self::TABLE)->field('id,account,nickname,email,mobile,status')->select();
        $this->ajaxReturn(['data' => $user_list]);
    }

    public function insert(){
        $request = I('request.');

        $mdl = M(self::TABLE);

        $tb_fields = $mdl->getDbFields();

        $insert = filterParams($request,$tb_fields);
        if ($mdl->where(['account'=> $insert['account']])->find()) {
            $this->ajaxReturn ( make_rtn ("account [{$insert['account']}] is existed"));
        }

        if ($mdl->where(['email' => $insert['email']])->find()) {
            $this->ajaxReturn ( make_rtn ("email [{$insert['email']}] is existed"));
        }

        if ($mdl->where(['mobile' => $insert['mobile']])->find()) {
            $this->ajaxReturn ( make_rtn ("mobile [{$insert['mobile']}] is existed"));
        }

        //default param
        $insert['create_time'] = time();
        $insert['password'] = hash('md5',$insert['password']);

        $rs = $mdl->add($insert);
        if($rs > 0){
            $this->ajaxReturn(make_url_rtn(Config::INSERT_COMPLETED_RETURN));
        }else {
            $this->ajaxReturn(make_rtn(Config::INSERT_FAILED));
        }
    }

    public function update(){
        $request = I('request.');

        $mdl = M(self::TABLE);

        $tb_fields = $mdl->getDbFields();
        $data = filterParams($request,$tb_fields);

        if ($mdl->where(['account'=> $data['account'],'id'=> ['neq',$data['id']]])->find()) {
            $this->ajaxReturn ( make_rtn ("account [{$data['account']}] is existed"));
        }

        if ($mdl->where(['email' => $data['email'],'id'=> ['neq',$data['id']]])->find()) {
            $this->ajaxReturn ( make_rtn ("email [{$data['email']}] is existed"));
        }

        if ($mdl->where(['mobile' => $data['mobile'],'id'=> ['neq',$data['id']]])->find()) {
            $this->ajaxReturn ( make_rtn ("mobile [{$data['mobile']}] is existed"));
        }

        $rs = $mdl->save($data);
        if($rs !== false ){
            $this->ajaxReturn(make_url_rtn(Config::UPDATE_COMPLETED_RETURN));
        }else {
            $this->ajaxReturn(make_rtn(Config::UPDATE_FAILED));
        }
    }

    public function changeStatus(){
        $request = I('request.');
        $data = filterParams($request,['id','status']);
        $rs = M(self::TABLE)->save($data);
        if($rs !== false ){
            $this->ajaxReturn(['status' => true]);
        }else {
            $this->ajaxReturn(make_rtn(Config::UPDATE_COMPLETED));
        }
    }

    public function resetPassword(){
        $post = I('post.');

        $mdl = M(self::TABLE);
        $verify = $mdl->where(['id'=> $post['id'],'password'=> hash('md5',$post['origin_passwd'])])->find();
        if($verify){
            $data = [
                'id' => $post['id'],
                'password' => hash('md5',$post['new_passwd'])
            ];
            if (false !== $mdl->save ($data)) {
                $this->ajaxReturn ( make_rtn("update success ~ new password is [ ".$post['new_passwd']." ]", true) );
            }else {
                $this->ajaxReturn ( make_rtn("reset password failed") );
            }
        }else{
            $this->ajaxReturn ( make_rtn("the origin password is wrong~") );
        }
    }
}