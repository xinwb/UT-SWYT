<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        session(null); 
        $this->display();
    }

    //ajax 处理检查登录名和密码
    public function login_check(){
        $vry = new \Think\Verify();  // yan zheng ma
        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        if(isset($_POST['do_login'])) {
            $given_username = $_POST['username'];
            $given_password = $_POST['passwd'];
            if($vry->check($_POST['verify'])){

                $iuser = new \Admin\Model\IadminModel();
                //    $iuser = new \Home\Model\IuserModel();
                $info = $iuser->checkNamePwd($given_username,$given_password);
                if($info){
                    $resp['accessGranted'] = true;
                    session('admin_id', $info['id']);
                    session('admin_name', $info['iname']);
                }
                else {                            // Failed Attempts
                    // $fa = isset($_COOKIE['failed-attempts']) ? $_COOKIE['failed-attempts'] : 0;
                    // $fa++;
                    // setcookie('failed-attempts', $fa);                                                                                  // Error message
                    $resp['errors'] = '<strong>登录失败!</strong><br />请输入正确的身份证号或密码: ';
                }
            }else{
                $resp['errors'] = '<strong>登录失败!</strong><br /> 验证码错误: ';
            }
        }
        echo json_encode($resp);
    }

    public function verifyImg() {
        // 给验证码做配置
        $cfg = array(
            'fontSize' => 15, // 验证码字体大小(px)
            'length' => 4, // 验证码位数
            'imageH' => 46, // 验证码图片高度
            'imageW' => 113, // 验证码图片宽度
            'fontttf' => '4.ttf', // 验证码字体，不设置随机获取
            'useCurve' => false, // 是否画混淆曲线
            'useNoise' => false, // 是否添加杂点	 true
            'bg' => array(176, 196, 222), // 背景颜色
        );

        $very = new \Think\Verify($cfg); //完全限定名称方式
        $very->entry();  //输出验证吗
    }

}
