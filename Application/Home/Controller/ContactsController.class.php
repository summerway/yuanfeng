<?php
/**
 * Created by PhpStorm.
 * User: summerway
 * Date: 16/2/21
 * Time: 下午9:04
 */
namespace Home\Controller;

/**
 * 联系我们
 * Class AboutController
 * @package Home\Controller
 */
class ContactsController extends CommonController
{
    /**
     *  联系我们首页
     */
    public function index()
    {
        $this->assign('title', '联系我们-宁波江东增拓贸易有限公司');

        $this->assign('keywords','宁波脚轮 环球脚轮 江东增拓有限公司 万向轮 液压车 平板车 脚杯 增拓官网');
        $this->assign('description','宁波江东增拓贸易有限公司是宁波脚轮专业供应商、环球脚轮驻宁波办事处，主要经营万向轮、液压车、平板车、脚杯、不锈钢脚杯。');
        $email= I('post.sub_email');
        if(!empty($email)){
            $this->assign('email',$email);
        }
        $this->display();
    }

    public function send(){
        $post = I('post.');
        $name= trim($post['name']);
        $email 	= trim($post['email']);
        $subject = trim($post['subject']);
        $message = trim($post['message']);

        //$result 	= $this->checkword($input,$cet_id);
        /*$verify = $_POST['verify'];
        if($_SESSION['verify'] != md5($verify))
        {
            $this->error = $_SESSION['verify'].'|'.md5($verify);
            $result = false;
        }else{
            $result = $this->sendmail($email,$name,$subject,$message);
        }*/

        $result = $this->sendmail($email,$name,$subject,$message);
       if(!$result){
            $this->ajaxReturn(make_rtn($this->getError()));
        }else{
            $this->ajaxReturn(make_rtn('success',true));
        }




    }
    // 错误信息字段
    public function getError() {
        return $this->error;
    }

    public function sendmail($sendto_email, $user_name='test', $subject='测试',$message='hello')
    {

        require_once ('./Vendor/phpmailer/class.phpmailer.php');

        $mail = new \PHPMailer();
        $mail->IsSMTP();                  // send via SMTP

        $mail->Host = C('MAIL_SMTP');   // SMTP servers
        $mail->SMTPAuth = true;           // turn on SMTP authentication
        $mail->Username = C('MAIL_ACCOUNT')  ;   // SMTP username  注意：普通邮件认证不需要加 @域名
        $mail->Password = C('MAIL_PASSWORD'); // SMTP password
        $mail->From = C('MAIL_SENDER');    // 发件人邮箱
        $mail->FromName = $user_name;  // 发件人

        $mail->CharSet = "utf-8";   // 这里指定字符集！
        $mail->Encoding = "base64";
        $mail->AddAddress(C('MAIL_RECEIVER'), '姚经理');  // 收件人邮箱和姓名
        $mail->IsHTML(true);  // send as HTML
        // 邮件主题
        $mail->Subject = $subject;

        // 邮件内容
        $mail->Body = '<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		.email_btn {
			background: #0F8CA8;
			padding: 5px 10px;
			color: #fff;
			width: 80px;
			text-align: center;
		}
	</style>
</head>
<body>

	<div style="width:540px;border:#0F8CA8 solid 2px;margin:0 auto">
		<div style="color:#fff;background:#0f8ca8;padding-left: 20px;overflow:hidden;zoom:1">
			<h1>游客留言</h1>
		</div>
		<div style="background:#fff;padding:20px;min-height:300px;position:relative">
			<div style="font-size:14px;">
				<p style="padding:0 0 20px;margin:0;font-size:12px">
					'.$mail->FromName.' 于'.date("F j, Y, g:i a").'给公司留言~
					<br>
					<br> 回复邮箱:<font color="grey">'.$sendto_email.'</font>
				</p>
				<p style="padding:0 0 20px;margin:0;font-size:12px">
					'.$message.'
				</p>
			</div>
		</div>
		<div style="background:#fff;">
			<div style="text-align:center;height:18px;line-height:18px;color:#999;padding:6px 0;font-size:12px">
				若不想再收到此类邮件，请点击
				<a href="#" style="text-decoration:none;color:#3366cc" target="_blank">设置</a>
			</div>
			<div style="line-height:18px;text-align:center">
				<p style="color:#999;font-size:12px">©2014 summer All Rights Reserved.</p>
			</div>
		</div>
	</div>
</body>
</html>
			';
        $mail->AltBody = "text/html";
        if (false === $mail->Send())
        {
            $mail->ClearAddresses();
            $this->error="邮件错误信息: " . $mail->ErrorInfo;
            return false;
        }
        else
        {
            $mail->ClearAddresses();
            return true;
            // $this->assign('waitSecond', 6);
            // $this->success("注册成功,系统已经向您的邮箱：{$sendto_email}发送了一封激活邮件!请您尽快激活~~<br />");
        }
    }
}