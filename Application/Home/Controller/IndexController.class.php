<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    //主页

	public function chafen(){
		$ip = get_client_ip();
        if (!$_SESSION['user_name']) { 
            echo "<script>alert('NOT LOAD!');window.location.href='index';</script>";
            $this->redirect('Login/index');
        }
        $map['iname'] = $_SESSION['user_name'];
        $iuser = M('iuser')->where($map)->find();
        if($user){
            $this->error('ssdfds');
        }
        $istat = $iuser['istat'];
        $kxzt = '';
        $kdzt = ' '; 
        $kdztsc = ' ';
        $kdztcq = ' ';//可点状态
        $tixing = '';
        $tixingbm = '';
        $wecq = '';
        $uinfostatxs='可以查询结果';
        if($iuser['iwecq'] == 'haha'){
            $wecq = 'disabled';
        }

        if($istat >= 1){
            if($istat == 1){
                $tixingbm = '请先报名!`';
            }
            if($istat > 1){
                $kxzt = 'disabled';
                if($istat >= 3){
                    $kdztsc = '';
                }
            }
            $kdzt = '';
        }else{
            $tixing = '请先完善个人信息';

        }


        //
        //0 可以填写信息
        //1 信息填写完毕 可以报名
        //3 报名成功信息不可修改
        //2 材料不通过
        //5 材料通过 专家审核
        //4 专家不过
        $systeminfo = M('system')->limit(1)->find();

        $this->systeminfo = $systeminfo;
        $itmz = M('tmz')->field('mzmc')->select();
        $imajor = M('imajor')->select();

        $icccc = '未选择';
        if($iuser['icmajor'] !=''){
            $mmaapp['id'] = $iuser['icmajor'];

            $icmajorname = M('imajor')->field('mname')->where($mmaapp)->find();
            if($icmajorname['mname'] == ''){

                $icccc = '未选择';
            }else{

                $tteemmpp = $icmajorname['mname'];
                $icccc ='已选择'.$tteemmpp;
            }

        }
        $majorsize = count($imajor);



        $sex['1'] = '男';
        $sex['2'] = '女';
        $kl['1'] = '文';
        $kl['2'] = '理';
        $kslb['1'] = '农村应届';
        $kslb['2'] = '城镇应届';
        $kslb['3'] = '农村往届';
        $kslb['4'] = '城镇往届';
        $zzmm['1'] = '群众';
        $zzmm['2'] = '共青团员';
        $zzmm['3'] = '预备党员';
        $zzmm['4'] = '中共党员';
        $alb['1'] = 'A';
        $alb['2'] = 'B';
        $alb['3'] = 'C';
        $alb['4'] = 'D';
        $alb['5'] = 'E';
        $alb['6'] = '无';


        //渲染页面
        switch($iuser['istat']){

        case 0:
            $uinfostatxs='完善信息未完成';
            break;
        case 1:
            $uinfostatxs='报名未完成';
            break;
        case 2:
            $uinfostatxs='材料审查未通过';
            break;
        case 3:
            $uinfostatxs='等待材料审查';
            break;
        case 4:
            $uinfostatxs='书面评审未通过';
            break;
        case 5:
            $uinfostatxs='等待书面评审';
            break;
        case 6:
            $uinfostatxs='请缴费';
            break;
        case 7:
            $uinfostatxs='抽签阶段';
            break;

        }

        $baomingxx = 'btn-success';

        if($iuser['istat'] >= 3)
        {
        
        $baomingxx = 'btn-primary';
        }

        $this->assign('baomingxx',$baomingxx);

        $tabuse = gettabid($iuser['istat']);
		if($iuser['istat'] == 7 && $systeminfo['scqkf'] == 1){
			$tabuse = 'kecq';
		}
		
        $this->tabuse = '#'.$tabuse;

        $icqkf = M('system')->limit(1)->find();
        $this->assign('icqkf',$icqkf['scqkf']);
        // 选考科目
        $xkkmmap['type'] = 0;
        $xkkm = M('xkkm')->where($xkkmmap)->select();
        $hkkm = M('xkkm')->select();
        dump($xkkm);die;
        $this->assign('hkkm',$hkkm);//会考科目 统计A时用
        $this->assign('xkkm',$xkkm);//选考科目，用户信息下拉列表用
        // 选考借宿
        // 综合素质评价

        $zhszpj[1] = 'A';
        $zhszpj[2] = 'B';
        $zhszpj[3] = 'C';
        $zhszpj[0] = 'P';
        $notices = M('notice')->select();


        $this->assign('notice',$notices);
        $this->assign('zhszpj',$zhszpj);
        $this->assign('uinfostatxs',$uinfostatxs);        //提醒
        $this->assign('wecq',$wecq);        //是否抽签
        $this->assign('uinfo',$iuser);      //用户信息
        $this->assign('kxzt',$kxzt);        //可写状态
        $this->assign('kdzt',$kdzt);        //可点状态
        $this->assign('kdztsc',$kdztsc);    //可点状态审查
        $this->assign('kdztcq',$kdztcq);    //可点状态抽签
        $this->assign('tixing',$tixing);    //提醒字符
        $this->assign('tixingbm',$tixingbm);//提醒报名
        $this->assign('kl',$kl);            //科类 文理
        $this->assign('alb',$alb);          //A类型
        $this->assign('sex',$sex);          //性别
        $this->assign('kslb',$kslb);        //考生类别
        $this->assign('zzmm',$zzmm);        //政治面貌
        $this->assign('major',$imajor);     //专业信息
        $this->assign('tmz',$itmz);         //民族
        $this->assign('majorsize',$majorsize);//专业个数
        $this->assign('iccc',$icccc);//已选大类名字
		$this->display();
	}
      public function zyupload(){
         $what = $_GET['what'];
        
        $this->assign('what',U($what));

        $this->display();
      }

      public function uploadysb(){

        $map['iname'] = $_SESSION['user_name'];
        $u = M('iuser')->where($map)->find();
        $disuse = '';
        if($u['istat'] >= 3){
        
        $disuse = 'disabled';
        }

        $asgetname = [];
        for($i = 1 ; $i<= 5 ;$i++){
        $map['irank'] = $i;
        $getfname = M('iupload')->where($map)->select();
        $asgetname[$i] = $getfname;;
        }
        $this->assign('gfn',$asgetname);
         $this->assign('u',$u); 
         $this->assign('disuse',$disuse); 
        $this->display();
      }
    
    public function delimg($id){ //图片删除
          M('iupload')->where(['id'=>$id])->delete()?$this->success('删除成功'):$this->error('未知错误');
        
    }
    public function test(){
     
        echo $Ags;
    dump($_POST);
    }
    public function help(){
        $this->display();
    }
    public function bigform(){
        $map['iname'] = $_SESSION['user_name'];		
        $istat  = M('iuser')->where($map)->field('istat')->find();
        $getpost = $_POST;
        $getpost['istat'] = 1;
        if($istat['istat'] <= 1){
            $ixkkm = M('xkkm')->select();
            foreach($ixkkm as $km){
                $hkbh[$km['id']] = $km['hkdh'];
            }
            $Ags = 0;
            foreach($hkbh as $bh){
                if($_POST[$bh] == 'A')
                    $Ags ++;
            }  
            $getpost['iahave'] = $Ags;
            $res = M('iuser')->where($map)->save($getpost);
            if($res){
                $info ='操作成功!';
                $data['status'] = 1;
            }else{
                $info = '提交成功！';
                $data['status'] = 0;
            }
        }else{
            $info = '已报名，信息无法修改，请刷新页面！';
            $data['status'] = $istat['istat'];
        }
        $data['data'] = $info;

        $this->success($info);
        //$this->ajaxReturn($data);
        //dump($_POST);
    }
	
	
	public function ggtixing(){
		$this->display();
	}

    public function index(){
		 //$this->redirect('ggtixing');
		// $this->redirect('index/chafen');
        $ip = get_client_ip();
        if (!$_SESSION['user_name']) { 
            echo "<script>alert('NOT LOAD!');window.location.href='index';</script>";
            $this->redirect('Login/index');
        }
        $map['iname'] = $_SESSION['user_name'];
        $iuser = M('iuser')->where($map)->find();
        if($user){
            $this->error('ssdfds');
        }
        $istat = $iuser['istat'];
        $kxzt = '';
        $kdzt = ' '; 
        $kdztsc = ' ';
        $kdztcq = ' ';//可点状态
        $tixing = '';
        $tixingbm = '';
        $wecq = '';
        $uinfostatxs='可以查询结果';
        if($iuser['iwecq'] == 'haha'){
            $wecq = 'disabled';
        }

        if($istat >= 1){
            if($istat == 1){
                $tixingbm = '请先报名!`';
            }
            if($istat > 1){
                $kxzt = 'disabled';
                if($istat >= 3){
                    $kdztsc = '';
                }
            }
            $kdzt = '';
        }else{
            $tixing = '请先完善个人信息';

        }


        //
        //0 可以填写信息
        //1 信息填写完毕 可以报名
        //3 报名成功信息不可修改
        //2 材料不通过
        //5 材料通过 专家审核
        //4 专家不过
        $systeminfo = M('system')->limit(1)->find();

        $this->systeminfo = $systeminfo;
        $itmz = M('tmz')->field('mzmc')->select();
        $imajor = M('imajor')->select();

        $icccc = '未选择';
        if($iuser['icmajor'] !=''){
            $mmaapp['id'] = $iuser['icmajor'];

            $icmajorname = M('imajor')->field('mname')->where($mmaapp)->find();
            if($icmajorname['mname'] == ''){

                $icccc = '未选择';
            }else{

                $tteemmpp = $icmajorname['mname'];
                $icccc ='已选择'.$tteemmpp;
            }

        }
        $majorsize = count($imajor);



        $sex['1'] = '男';
        $sex['2'] = '女';
        $kl['1'] = '文';
        $kl['2'] = '理';
        $kslb['1'] = '农村应届';
        $kslb['2'] = '城镇应届';
        $kslb['3'] = '农村往届';
        $kslb['4'] = '城镇往届';
        $zzmm['1'] = '群众';
        $zzmm['2'] = '共青团员';
        $zzmm['3'] = '预备党员';
        $zzmm['4'] = '中共党员';
        $alb['1'] = 'A';
        $alb['2'] = 'B';
        $alb['3'] = 'C';
        $alb['4'] = 'D';
        $alb['5'] = 'E';
        $alb['6'] = '无';


        //渲染页面
        switch($iuser['istat']){

        case 0:
            $uinfostatxs='完善信息未完成';
            break;
        case 1:
            $uinfostatxs='报名未完成';
            break;
        case 2:
            $uinfostatxs='材料审查未通过';
            break;
        case 3:
            $uinfostatxs='等待材料审查';
            break;
        case 4:
            $uinfostatxs='书面评审未通过';
            break;
        case 5:
            $uinfostatxs='等待书面评审';
            break;
        case 6:
            $uinfostatxs='请缴费';
            break;
        case 7:
            $uinfostatxs='抽签阶段';
            break;

        }

        $baomingxx = 'btn-success';

        if($iuser['istat'] >= 3)
        {
        
        $baomingxx = 'btn-primary';
        }

        $this->assign('baomingxx',$baomingxx);

        $tabuse = gettabid($iuser['istat']);
		if($iuser['istat'] == 7 && $systeminfo['scqkf'] == 1){
			$tabuse = 'kecq';
		}
		
        $this->tabuse = '#'.$tabuse;

        $icqkf = M('system')->limit(1)->find();
        $this->assign('icqkf',$icqkf['scqkf']);
        // 选考科目
        $xkkmmap['type'] = 0;
        $xkkm = M('xkkm')->where($xkkmmap)->select();
        $hkkm = M('xkkm')->select();
        $this->assign('hkkm',$hkkm);//会考科目 统计A时用
        $this->assign('xkkm',$xkkm);//选考科目，用户信息下拉列表用
        // 选考借宿
        // 综合素质评价

        $zhszpj[1] = 'A';
        $zhszpj[2] = 'B';
        $zhszpj[3] = 'C';
        $zhszpj[0] = 'P';
        $notices = M('notice')->select();


        $this->assign('notice',$notices);
        $this->assign('zhszpj',$zhszpj);
        $this->assign('uinfostatxs',$uinfostatxs);        //提醒
        $this->assign('wecq',$wecq);        //是否抽签
        $this->assign('uinfo',$iuser);      //用户信息
        $this->assign('kxzt',$kxzt);        //可写状态
        $this->assign('kdzt',$kdzt);        //可点状态
        $this->assign('kdztsc',$kdztsc);    //可点状态审查
        $this->assign('kdztcq',$kdztcq);    //可点状态抽签
        $this->assign('tixing',$tixing);    //提醒字符
        $this->assign('tixingbm',$tixingbm);//提醒报名
        $this->assign('kl',$kl);            //科类 文理
        $this->assign('alb',$alb);          //A类型
        $this->assign('sex',$sex);          //性别
        $this->assign('kslb',$kslb);        //考生类别
        $this->assign('zzmm',$zzmm);        //政治面貌
        $this->assign('major',$imajor);     //专业信息
        $this->assign('tmz',$itmz);         //民族
        $this->assign('majorsize',$majorsize);//专业个数
        $this->assign('iccc',$icccc);//已选大类名字

        $this->display();
    }

    function checkstat(){

        $str =  $_REQUEST['str'];

        $map['iname'] = $_SESSION['user_name'];

        $iuser = M('iuser')->where($map)->field('istat')->find();

        $istat = $iuser['istat'];
        $data['status'] = 1;

        $info['statsxs'] = 'sadsa';
        switch($str){
        case 'kebm':

            if($istat < 1)
            {
                $data['status'] = 0;

                $info['statsxs'] = '请先完善信息';
            }
            break;
        case 'kesc':

            if($istat < 3)
            {

                $info['statsxs'] = '请先报名';
                $data['status'] = 0;
            }
            break;
        case 'kecq':

            if($istat < 5){
                $data['status'] = 0;

                $info['statsxs'] = '等待抽签系统开放';
            }
            break;
        default:
            break;

        }
        $info['useid'] = $str;
        $data['data'] = $info;
        $this->ajaxReturn($data);
    }

    //选择专业后报名  istat = 3
    public function csmajor(){
        $str['icmajor'] =  $_REQUEST['str'];
        $map['iname'] = $_SESSION['user_name'];



        $uploadsf = 0;
        $map22['iname'] = $_SESSION['user_name'];
        $map22['irank'] = '1';
        $uploadhave = M('iupload')->where($map22)->find();
        $uploadpic = M('iuser')->where($map22)->field('id,iid,istat,ipic')->find();
       
        if($uploadhave == '' ){
            $uploadsf = 1;
        }

        if($uploadpic['ipic']==''){
            $uploadsf = 2;
        }

        if($uploadsf == 0){

            $user = M('iuser');
            $have = $user->max('iid');;
            $iuser = M('iuser')->where($map)->field('id,iid,istat,ibkkm1,ibkkm2,ibkkm3')->find();
            if(!$iuser['iid']){
                $str['iid'] = $iuser['id'];
            }
            $xkid = M('mjxk')->where(array('mjid'=>$str['icmajor']))->select();
            $ibkkm[0]=$iuser['ibkkm1']; 
            $ibkkm[1]=$iuser['ibkkm2']; 
            $ibkkm[2]=$iuser['ibkkm3']; 
            $temp = 0;
            foreach($xkid as $vo){
                if(in_array($vo[xkid],$ibkkm)){
                    $temp = 1; 
                    break;
                }
            }
            if($iuser['istat'] <= 1 && $temp != 0){
                $str['istat'] = 3; // 
                $res = M('iuser')->where($map)->save($str);
                if($res){
                    $info['info'] = '操作成功！';
                    $data['status'] = 1; 
                }else{
                    $info['info'] = '操作失败！';
                    $data['status'] = 0; 
                }
            }else{

                $info['info'] = '已报名，信息无法修改，请刷新页面！';
                $data['status'] = $iuser['istat']; 

            }
            $info['stats'] = 3;

            if($temp == 0){

                $data['status'] = 0; 
                $info['info'] = '所选大类与选考科目不符！';
            }

        }
        if($uploadsf == 1){

            $data['status'] = 0; 
            $info['info'] = '请在完善信息页面上传身份证明！';
        }

         if($uploadsf == 2){

            $data['status'] = 0; 
            $info['info'] = '请在完善信息页面上传个人照片！';
        }

            // $data['status'] = 0; 
            // $info['info'] = $str['icmajor'];
        $data['data'] = $info;
        $this->ajaxReturn($data);
    }


    private function judje($item){

        $map22['iname'] = $_SESSION['user_name'];

        $bkkm = M('iuser')->where($map22)->field('ibkkm1,ibkkm2,ibkkm3')->find();

        $map11['mjid'] = $item;
        $mjxk = M('mjxk')->where($map11)->field('xkid')->select();
        foreach ($mjxk as $key => $value) {
            # code...
            if(in_array($value['xkid'],$bkkm)){
                return true;
            }

        }

        return false;


    }

    //完善ems
    public function wanshanems(){
        $map['iname'] = $_SESSION['user_name'];
        $str =  $_REQUEST['str'];


        $data['iems'] = $str;

        $res = M('iuser')->where($map)->save($data);

        if($res){
            $info = '填写成功!';
            $data['status'] = 1; 
        }else{
            $info = '提交成功';
            $data['status'] = 0; 
        }
        $data['data'] = $info;
        $this->ajaxReturn($data);
    }

    //抽签use
    public function chouqianuse(){
        $map['iname'] = $_SESSION['user_name'];
        $baoc['iwecq'] = 'haha';
        $res = M('iuser')->where($map)->field('icqqh,iwecq')->find();
        if(!$res['iwecq']){
            $info = $res['icqqh'];
            $data['status'] = 1; 
        }else{

            $info = '提交成功';
            $data['status'] = 0; 
        }
        M('iuser')->where($map)->save($baoc);
        $data['data'] = $info;
        $this->ajaxReturn($data);
    }
    //信息完善确认
    public function xinxiwanshan(){
        $map['iname'] = $_SESSION['user_name'];
        $str['istat'] = 1; // 
        $res = M('iuser')->where($map)->save($str);
        if($res){
            $info['info'] = '操作成功！';
            $data['status'] = 1; 
        }else{
            $info['info'] = '提交成功！';
            $data['status'] = 0; 
        }
        $info['stats'] = 1;
        $data['data'] = $info;
        $this->ajaxReturn($data);
    }
   public function jiaofeisign(){
	   
	    $sys = M('system')->where('id = 1')->find();
	   
        $key = $sys['syskey'];

        $orderDate = $_POST['orderDate'];
        $orderNo = $_POST['orderNo'];
        $amount = $_POST['amount'];
        $jylsh = $_POST['jylsh'];
        $tranStat = $_POST['tranStat'];
        $return_type = $_POST['return_type'];
        $sign = $_POST['sign'];

        $wait_sign_str = 'orderDate='.$orderDate.'&orderNo='.$orderNo.'&amount='.$amount.'&jylsh='.$jylsh.'&tranStat='.$tranStat.'&return_type='.$return_type;
        $board_message = $wait_sign_str.$key;

        $deSign = MD5($board_message);

        if($sign === $deSign){

            //获取缴费用户
            $map['iorderNo'] = $orderNo;
            $iname = M('iuser')->where($map)->find();
           // echo $iname;
            $map['iname'] = $iname['iname'];
            $data['istat'] = 7;
            $data['iisjf'] = 1;
            $data['ijylsh'] = $jylsh;
            $iuser = M('iuser')->where($map)->save($data);
			echo 'success';

        }else{
            
        }
    } 
	   public function jiaofeisignold(){
	   
	   $sys = M('system')->where('id = 1')->find();
	   
        $key = $sys['syskey'];

        $orderDate = $_GET['orderDate'];
        $orderNo = $_GET['orderNo'];
        $amount = $_GET['amount'];
        $jylsh = $_GET['jylsh'];
        $tranStat = $_GET['tranStat'];
        $return_type = $_GET['return_type'];
        $sign = $_GET['sign'];

        $wait_sign_str = 'orderDate='.$orderDate.'&orderNo='.$orderNo.'&amount='.$amount.'&jylsh='.$jylsh.'&tranStat='.$tranStat.'&return_type='.$return_type;
        $board_message = $wait_sign_str.$key;

        $deSign = MD5($board_message);

        if($sign === $deSign){

            //获取缴费用户
            $map['iorderNo'] = $orderNo;
            $iname = M('iuser')->where($map)->find();
           // echo $iname;
            $map['iname'] = $iname['iname'];
            $data['istat'] = 7;
            $data['iisjf'] = 1;
            $data['ijylsh'] = $jylsh;
            $iuser = M('iuser')->where($map)->save($data);
            $this->success('缴费成功','index');

        }else{
            $this->success('缴费失败','index');
        }
        

    } 
	public function jiaofeisign2(){
	   
	   $sys = M('system')->where('id = 1')->find();
	   
        $key = $sys['syskey'];

        $orderDate = $_POST['orderDate'];
        $orderNo = $_POST['orderNo'];
        $amount = $_POST['amount'];
        $jylsh = $_POST['jylsh'];
        $tranStat = $_POST['tranStat'];
        $return_type = $_POST['return_type'];
        $sign = $_POST['sign'];

        $wait_sign_str = 'orderDate='.$orderDate.'&orderNo='.$orderNo.'&amount='.$amount.'&jylsh='.$jylsh.'&tranStat='.$tranStat.'&return_type='.$return_type;
        $board_message = $wait_sign_str.$key;

        $deSign = MD5($board_message);

        if($sign === $deSign){

            //获取缴费用户
            $map['iorderNo'] = $orderNo;
            $iname = M('iuser')->where($map)->find();
           // echo $iname;
            $map['iname'] = $iname['iname'];
            $data['istat'] = 7;
            $data['iisjf'] = 1;
            $data['ijylsh'] = $jylsh;
            $iuser = M('iuser')->where($map)->save($data);
			echo 'success';

        }else{
            
        }
        

    } 
	public function test11(){
		 $sys = M('system')->where('id = 1')->find();
		 dump($sys);
	}
	
    public function jiaofeiuse(){
		$sys = M('system')->where('id = 1')->find();
	   
        $key = $sys['syskey'];
		
        $map['iname'] = $_SESSION['user_name'];
        //判断缴费资格$judje
        $judje  = 1;

        $iuser = M('iuser')->where($map)->find();
		if($iuser['iisjf'] == 1){
            $this->error('缴费出错','index');
        }
        if($iuser['istat'] != 6){
            $this->error('缴费出错,您未通过审核','index');
        }
        if($iuser['iisjf'] == 1){
            $this->error('您已缴费！','index');
        }
        if($judje != 1){
        
            $this->error('缴费出错','index');

        }
		
		$codeid = $iuser['id'];


        $code1 = substr($map['iname'],-5);
        $code2 = rand(1000,9999);
        
        $action = $sys['systoadd'];
        $amount = "110.00";
       
        $orderDate = date("YmdHis");
        $orderNo = date("Y").sprintf("%04d",$codeid).$code1.$code2;
        $xmpch = $sys['idid']; 
        $return_url = 'http://115.236.84.165/index.php/Index/jiaofeisignold';
        $notify_url = 'http://115.236.84.165/index.php/Index/jiaofeisign2';

        $wait_sign_str = 'orderDate='.$orderDate.'&orderNo='.$orderNo.'&amount='.$amount.'&xmpch='.$xmpch.'&return_url='.$return_url.'&notify_url='.$notify_url;
        $board_message = $wait_sign_str.$key;

        $sign = MD5($board_message);



        //保存订单号

        $map['iname'] = $_SESSION['user_name'];
        $data['iorderNo'] = $orderNo;
        $iuser = M('iuser')->where($map)->save($data);

		$datacode['iname'] = $map['iname'];
        $datacode['iorderNo'] = $data['iorderNo'];
        M('ordercode')->add($datacode);



        // 
        $this->action = $action; 
        $this->amount = $amount;
        $this->sign = $sign;
        $this->orderDate = $orderDate;
        $this->orderNo = $orderNo;
        $this->xmpch  = $xmpch; 
        $this->return_url = $return_url;
        $this->notify_url = $notify_url; 
        // echo $sign;
        $this->display();

    }
    public function jiaofei(){

        $map['iname'] = $_SESSION['user_name'];
        // $data['istat'] = 7;
        // $iuser = M('iuser')->where($map)->save($data);
        $this->success('缴费成功','index');
    }
    public function xianshi(){
        $map['iname'] = $_SESSION['user_name'];
        $temp  = M('iuser')->where($map)->field('istat,iwecq')->find();
        $istat = $temp['istat'];
        $use;

        switch($istat){

        case 0:
            $use = 1;
            break;
        case 1:
            $use = 2;
            break;
        case 2:
            $use = 4;
            break;
        case 3:
            $use = 3;
            break;
        case 4:
            $use = 5;
            break;
        case 5:
            $use = 4;
            break;
        case 6:
            $use = 5;
            break;
        case 7:
            $use = 6;
            if($temp['iwecq'] == 'haha'){
                $use = 7;
            }
            break;

        case 8:
            $use = 8;
            break;
        default:

            $use = 5;
            break;
        }
        //echo $istat;
        $this->istat = $use;
        $this->display();
    }


    //保存基本信息
    //所有表单传递 通过thinkajax sendfrom 传递到这-----
    //---000---000---
    //2016--12--02
    //检测istat状态

    public function jbxx(){
        $map['iname'] = $_SESSION['user_name'];
        $istat  = M('iuser')->where($map)->field('istat')->find();

        if($istat['istat'] <= 1){
            $res = M('iuser')->where($map)->save($_POST);
            if($res){
                $info ='操作成功!';
                $data['status'] = 1; 
            }else{
                $info = '提交成功！';
                $data['status'] = 0; 
            }
        }else{
            $info = '已报名，信息无法修改，请刷新页面！';
            $data['status'] = $istat['istat']; 
        }
        $data['data'] = $info;
        $this->ajaxReturn($data);
    }

    //    public function jbxxhk(){
    //        $map['iname'] = $_SESSION['user_name'];
    //        $istat  = M('iuser')->where($map)->field('istat')->find();
    //        $kk = 0;
    //        if($istat['istat'] <= 1){
    //            $ii = 0;
    //            foreach ($_POST as $key => $value) {
    //                # code...
    //                if($ii < 12 and $value == 'A'){
    //                    $kk++;
    //                }
    //                $ii++;
    //            }
    //            $savedata['iahave'] = $kk;
    //            $res = M('iuser')->where($map)->save($_POST);
    //            $res2 = M('iuser')->where($map)->save($savedata);
    //
    //
    //            if($res){
    //                $info =$kk;
    //                $data['status'] = 1;
    //            }else{
    //                $info = '提交成功！';
    //                $data['status'] = 0;
    //            }
    //        }else{
    //            $info = '已报名，信息无法修改，请刷新页面！';
    //            $data['status'] = $istat['istat'];
    //        }
    //        $data['data'] = $info;
    //        $this->ajaxReturn($data);
    //    }




    public function save(){
        if (!$_SESSION['user_name']) { 
            echo "<script>alert('NOT LOAD!');window.location.href='index';</script>";
            $this->redirect('Login/index');
        }
        $map['iname'] = $_SESSION['user_name'];
        $iuser = M('iuser')->where($map)->find();
        if($user){
            $this->error('ssdfds');
        }
        $year =  date('Y', time());
        $xuhao = $year*10000 + $iuser['id'];
        $this->assign('xuhao',$xuhao);
        $this->assign('uinfo',$iuser);
        $this->display();
    }

    public function savezm(){
        if (!$_SESSION['user_name']) { 
            echo "<script>alert('NOT LOAD!');window.location.href='index';</script>";
            $this->redirect('Login/index');
        }

        
        $map['iname'] = $_SESSION['user_name'];
        $iuser = M('iuser')->where($map)->field('ipiczm')->find();
        $zt = 'none';
        if($iuser['ipiczm'] != ''){

            $zt = '';
        }
        $this->ipiczm = $zt;
        $this->display();
    }

    public function sfupload(){


        $iprank = $_GET['iprank'];
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     6164480 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','zip','rar');// 设置附件上传类型
        $upload->rootPath  =     './Public/usepiczm/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();

        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息

            $iname = $_SESSION['user_name'];
            $savepath = $info['photo']['savepath'];
            $savename = $info['photo']['savename'];
            $pic = $savepath.$savename;
            
            $filename1 = $info['photo']['name'];
            $data['oldname'] =$filename1;

            $map['iname'] = $iname;
            $data['iloadsrc'] = $pic;
            $data['iname'] = $iname;
            $data['irank'] = $iprank;
            $iuser = M('iupload')->add($data);

            $maprank['irank'] = $iprank;
            $maprank['iname'] = $iname;

            $iihave = M('iupload')->where($maprank)->count();
            $map11['iname'] = $iname;
            $sczmn = 'isczm'.$iprank;
            $map22[$sczmn] = $iihave;
            M('iuser')->where($map11)->save($map22);

            if($iuser){

                $this->success('上传成功!');
            }else{
                // echo "asdasd";
                $this->error($upload->getError());
            }
        }
    }





    //上传照片
    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     6164480 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/usepic/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();

        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息

            $iname = $_SESSION['user_name'];
            $savepath = $info['photo']['savepath'];
            $savename = $info['photo']['savename'];
            $pic = $savepath.$savename;

            $map['iname'] = $iname;
            $data['ipic'] = $pic;
            $iuser = M('iuser')->where($map)->save($data);
            if($iuser){

                $this->success('上传成功!');
            }else{
                // echo "asdasd";
                $this->error($upload->getError());
            }
        }
    }


















    public function savesome(){

        $what = $_GET['what'];
        $this->assign('what',U($what));

        $this->display();
    }

    public function uploadzmsf(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     6164480 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/usepiczm/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $iname = $_SESSION['user_name'];
            $savepath = $info['file']['savepath'];
            $savename = $info['file']['savename'];
            $pic = $savepath.$savename;

            $data['iname'] = $iname;
            $data['irank'] = 1;
            $data['iloadsrc'] = $pic;
            $iuser = M('iupload')->add($data);
            if($iuser){
                 $this->success('上传成功!');
            }else{
                $this->error($upload->getError());
            }
        }
    }
    //上传国家级证明
    public function uploadzmgj(){

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     6164480 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/usepiczm/'; // 设置附件上传根目录
         $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $iname = $_SESSION['user_name'];
            $savepath = $info['file']['savepath'];
            $savename = $info['file']['savename'];
            $pic = $savepath.$savename;

            $data['iname'] = $iname;
            $data['irank'] = 2;
            $data['iloadsrc'] = $pic;
            $iuser = M('iupload')->add($data);
            if($iuser){
                  $this->success('上传成功!');
            }else{
                $this->error($upload->getError());
            }
        }
    }
    //上传相关证明
    public function uploadzmshj(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     6164480 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/usepiczm/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $iname = $_SESSION['user_name'];
            $savepath = $info['file']['savepath'];
            $savename = $info['file']['savename'];
            $pic = $savepath.$savename;

            $data['iname'] = $iname;
            $data['irank'] = 3;
            $data['iloadsrc'] = $pic;
            $iuser = M('iupload')->add($data);
            if($iuser){
                   $this->success('上传成功!');
            }else{
                $this->error($upload->getError());
            }
        }
    }
    //上传相关证明
    public function uploadzmsj(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     6164480 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/usepiczm/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $iname = $_SESSION['user_name'];
            $savepath = $info['file']['savepath'];
            $savename = $info['file']['savename'];
            $pic = $savepath.$savename;

            $data['iname'] = $iname;
            $data['irank'] = 4;
            $data['iloadsrc'] = $pic;
            $iuser = M('iupload')->add($data);
            if($iuser){
                $this->success('上传成功!');
            }else{
                $this->error($upload->getError());
            }
        }
    }
    //上传相关证明
    public function uploadzmqtj(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     6164480 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/usepiczm/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $iname = $_SESSION['user_name'];
            $savepath = $info['file']['savepath'];
            $savename = $info['file']['savename'];
            $pic = $savepath.$savename;

            $data['iname'] = $iname;
            $data['irank'] = 5;
            $data['iloadsrc'] = $pic;
            $iuser = M('iupload')->add($data);
            if($iuser){
                  $this->success('上传成功!');
            }else{
                $this->error($upload->getError());
            }
        }
    }
    //上传相关证明
    public function uploadzm(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     6164480 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/usepiczm/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $iname = $_SESSION['user_name'];
            $savepath = $info['file']['savepath'];
            $savename = $info['file']['savename'];
            $pic = $savepath.$savename;
            $map['iname'] = $iname;
            $data['ipiczm'] = $pic;
            $iuser = M('iuser')->where($map)->save($data);
            if($iuser){
                //   $this->success('上传成功!');
            }else{
                $this->error($upload->getError());
            }
        }
    }


}


