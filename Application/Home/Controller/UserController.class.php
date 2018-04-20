<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller{

    
    public function index(){
        echo "User-index";
    }

    public function sad(){

        if($_SESSION['user_name'] == ''){
        
            $this->redirect('Login/index');
        
        } 
        $map['iname'] = $_SESSION['user_name'];
        $iuser = M('iuser')->where($map)->find();
        if($iuser['istat'] == 2){
        
            $info = '书面评审未通过';
            $beizhu = $iuser['ishjl'];
        }else{
            $info = '材料审核未通过';
            $beizhu = $iuser['ibsjl'];
        }

       session(null);
        echo $info."未通过！";
    }
    public function ajaxuse(){

        $data['status'] = 1;
        $temp['name'] = $_POST['name'];
        $temp['pwd'] = $_POST['pwd'];
        $data['data'] = $temp;
        $this->ajaxReturn($data);

    }

    public function datetest(){
        var_dump($_POST);
    }

    public function ptzzkwithcode(){
        //if (!$_SESSION['user_name']){}

        $map['iname'] = $_GET['useruse'];
        $iuser = M('iuser')->where($map)->find();
        if(!$iuser){
            $this->error('无此学生信息');
		
        }
        $mapmj['id'] = $iuser['icmajor'];
        $imajor = M('imajor')->where($mapmj)->find();
        $mjlb = $imajor['mcode'];
        $mjname = $imajor['mname'];
        $year =  date('Y', time());
        $xuhao = $mjlb.' '.$year.sprintf("%04d",$iuser['id']);

        $izkzh =  $year.sprintf("%02d",0).$mjlb.sprintf("%04d",$iuser['icqqh']);
        $this->assign('mjlb',$mjlb.' '.sprintf("%04d",$iuser['icqqh']));
        $this->assign('mname',$mjname);
        $this->assign('izkzh',$izkzh); 
        $this->assign('year',$year);
        $this->assign('xuhao',$xuhao);
        $this->assign('uinfo',$iuser);
        //
        // $html = $this->fetch(); 
        // Vendor('mpdf.mpdf');
        //
        // $mpdf = new \mPDF('zh-cn','A4',0,'宋体',0,0);
        // $mpdf->SetWatermarkText('浙江农林大学',0.1);
        //
        // $mpdf->showWatermarkText = true;
        // // $mpdf->SetHTMLHeader( '头部' );
        // // $mpdf->SetHTMLFooter( '底部' );
        // $mpdf->Writehtml($html); 
        // $mpdf->Output();
        // exit;

          $this->display();
    }

    public function ptzzk(){
        //if (!$_SESSION['user_name']){}

        $map['iname'] = $_SESSION['user_name'];
        $iuser = M('iuser')->where($map)->find();
        if(!$iuser){
            $this->error('无此学生信息');
        }
        $mapmj['id'] = $iuser['icmajor'];
        $imajor = M('imajor')->where($mapmj)->find();
        $mjlb = $imajor['mcode'];
        $mjname = $imajor['mname'];
        $year =  date('Y', time());
        $xuhao = $mjlb.' '.$year.sprintf("%04d",$iuser['id']);

        $izkzh =  $year.sprintf("%02d",0).$mjlb.sprintf("%04d",$iuser['icqqh']);
        $this->assign('mjlb',$mjlb.' '.sprintf("%04d",$iuser['icqqh']));
        $this->assign('mname',$mjname);
        $this->assign('izkzh',$izkzh); 
        $this->assign('year',$year);
        $this->assign('xuhao',$xuhao);
        $this->assign('uinfo',$iuser);

        $html = $this->fetch();
         
        Vendor('mpdf.mpdf');

        $mpdf = new \mPDF('zh-cn','A4',0,'宋体',0,0);
        $mpdf->SetWatermarkText('浙江农林大学',0.1);

        $mpdf->showWatermarkText = true;
        // $mpdf->SetHTMLHeader( '头部' );
        // $mpdf->SetHTMLFooter( '底部' );
        $mpdf->Writehtml($html); 
        $mpdf->Output();
        exit;

          // $this->display();
    }




    public function ptinfo(){
        //if (!$_SESSION['user_name']){}

        $map['iname'] = $_SESSION['user_name'];
        if(!empty($_GET['iname'])){
            $map['iname'] = $_GET['iname'];
        }
        $iuser = M('iuser')->where($map)->find();
        if(!$iuser){
            $this->error('无此学生信息');
        }
        $mapmj['id'] = $iuser['icmajor'];
        $imajor = M('imajor')->where($mapmj)->find();
        $mjlb = $imajor['mcode'];
        $year =  date('Y', time());
        $xuhao = $mjlb.' '.$year.sprintf("%04d",$iuser['id']);

        $xkmap['id'] = array('in',array($iuser['ibkkm1'],$iuser['ibkkm2'],$iuser['ibkkm3']));
        $ixkkm = M('xkkm')->where($xkmap)->field('kmname')->select();
        $this->imajor = $imajor['mname'];

        $this->ixkkm = $ixkkm;
        $this->assign('xuhao',$xuhao);//分类加报名序号
        $this->assign('uinfo',$iuser);//基本信息

        // var_dump($iuser);


        $html = $this->fetch();
        // echo $html;
        Vendor('mpdf.mpdf');

        $mpdf = new \mPDF('zh-cn','A4',0,'宋体',0,0);
        $mpdf->SetWatermarkText('浙江农林大学',0.1);

        $mpdf->showWatermarkText = true;
        // $mpdf->SetHTMLHeader( '头部' );
        // $mpdf->SetHTMLFooter( '底部' );
        $mpdf->Writehtml($html);
        $mpdf->Output();
        exit;

           // $this->display();
    }

    public function ptinfowithoutcode(){
        //if (!$_SESSION['user_name']){}


        $map['iname'] = $_GET['useruse'];
        if(!empty($_GET['iname'])){
            $map['iname'] = $_GET['iname'];
        }
        $iuser = M('iuser')->where($map)->find();
        if(!$iuser){
            $this->error('无此学生信息');
        }
        $mapmj['id'] = $iuser['icmajor'];
        $imajor = M('imajor')->where($mapmj)->find();
        $mjlb = $imajor['mcode'];
        $year =  date('Y', time());
        $xuhao = $mjlb.' '.$year.sprintf("%04d",$iuser['id']);

        $xkmap['id'] = array('in',array($iuser['ibkkm1'],$iuser['ibkkm2'],$iuser['ibkkm3']));
        $ixkkm = M('xkkm')->where($xkmap)->field('kmname')->select();
        $tempat = 0;
        if($iuser['ibsjl'] != ''){
            $tempat = 1;
        }
        $this->ixkkm = $ixkkm;
        $this->assign('tempat',$tempat);
        $this->assign('xuhao',$xuhao);//分类加报名序号
        $this->assign('uinfo',$iuser);//基本信息

        // var_dump($iuser);



        $this->display();
    }


    public function ptinfowithcode(){
        //if (!$_SESSION['user_name']){}


        $map['iname'] = $_GET['useruse'];
        if(!empty($_GET['iname'])){
            $map['iname'] = $_GET['iname'];
        }
        $iuser = M('iuser')->where($map)->find();
        if(!$iuser){
            $this->error('无此学生信息');
        }
        $mapmj['id'] = $iuser['icmajor'];
        $imajor = M('imajor')->where($mapmj)->find();
        $mjlb = $imajor['mcode'];
        $year =  date('Y', time());
        $xuhao = $mjlb.' '.$year.sprintf("%04d",$iuser['id']);

        $xkmap['id'] = array('in',array($iuser['ibkkm1'],$iuser['ibkkm2'],$iuser['ibkkm3']));
        $ixkkm = M('xkkm')->where($xkmap)->field('kmname')->select();
        $this->imajor = $imajor['mname'];

        $this->ixkkm = $ixkkm;
        $this->assign('xuhao',$xuhao);//分类加报名序号
        $this->assign('uinfo',$iuser);//基本信息

        // var_dump($iuser);





        $this->display();
    }


    //二维码生成
    public function qrcode($level = 3,$size=3){

        $iuser = $_GET['iname'];

        $url = U('User/ptzzkwithcode',array('useruse' => 'useriname'));

        if($iuser){
            $url = str_replace('useriname',$iuser,$url);

            $url = str_replace('/swyt','',$url);
            $url = 'http://115.236.84.165'.$url;
        }else{
            $url = "dfsgdsf";
        }
        //  echo $url;
        Vendor('phpqrcode.phpqrcode');
        $errorCorrectionLevel =intval($level) ;//容错级别 
        $matrixPointSize = intval($size);//生成图片大小 
        //生成二维码图片 
        //  //echo $_SERVER['REQUEST_URI'];
        $object = new \QRcode();
        $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);



    }




}

