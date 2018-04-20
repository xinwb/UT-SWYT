<?php
namespace Home\Controller;
use Think\Controller;



class LoginController extends Controller {

    public function index(){
        //清除session 
       session(null);
		//$this->redirect('index/ggtixing');
        $bro = getBrowser();
        $var =  getBrowserVer();
        if($bro == 'ie'){
           $this->redirect('llq');
        }
        $this->display();
    }

    public function login_check(){
        $vry = new \Think\Verify();  // yan zheng ma
        $resp = array('accessGranted' => false, 'errors' => '','statok' => ''); // For ajax response
        if(isset($_POST['do_login'])) {
            $given_username = $_POST['username'];
            $given_password = $_POST['passwd'];
            if($vry->check($_POST['verify'])){
                $iuser = new \Home\Model\IuserModel();
                $info = $iuser->checkNamePwd($given_username,$given_password);
                if($info){
                    $resp['accessGranted'] = true;
                    session('user_id', $info['id']);
                    session('user_name', $info['iname']);
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

        $maap['iname'] = $info['iname'];
        $statok = M('iuser')->where($maap)->field('istat')->find();
        $resp['statok'] = $statok['istat'];
        echo json_encode($resp);
    }

    public function ptcheck(){

        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
    
        if(isset($_POST['do_regist'])) {


            if($_POST['ipwd'] == $_POST['ipwd2']){            
                //  $resp['accessGranted'] = false;
                $iname = $_POST['iname'];
                $ipwd = $_POST['ipwd'];
                $ixm = $_POST['ixm'];
				$imobile = $_POST['imobile'];
                $iaddr = $_POST['addr'];
                $xxb = $_POST['xxb'];
                $icssj = $_POST['cssj'];
           
                if($xxb == 0){
                    
                    $ixb='女';
                }else{
                
                    $ixb='男';
                }

                $map['iname'] = $iname;
                $res = M('iuser')->where($map)->find();
                if($res){
                    $resp['errors'] = '<strong>注册失败!</strong><br />此身份证已经注册请前往登录!';
                }else{
                    $data['iname'] = $iname;
                    $data['ipwd'] = $ipwd;
                    // $data['ixb'] = $ixb;
                    // $data['iaddr'] = $iaddr;
                    $data['icssj'] = $icssj;
                    $data['ixm'] = $ixm;
					$data['imobile'] = $imobile;
                    $data['idata'] = date('Y-m-d H:i:s', time());
                    $che = M('iuser')->data($data)->add();
                    if($che){
                    $resp['accessGranted'] = true;
                    }else{
                    
                    $resp['errors'] = '<strong>注册失败!</strong><br />未知原因--请重试，或联系学校!';
                    }
                }
            }else{
                $resp['errors'] = '<strong>注册失败</strong><br />密码不一致';
            }

        }
        echo json_encode($resp);
    }

    public function ptpost(){
        var_dump($_GET);
    }

    //zhu ce 
    public function  regist(){
		//$this->redirect('index/ggtixing');
        session(null); 
        $this->display();
    }

    public function llq(){
        $this->display();
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
