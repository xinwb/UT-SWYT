<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {


    public function posttest(){

        dump($_POST);
    }


    public function topbaruse(){

        $this->display();
    }

    public function index() {
        //$this->redirect('Login/index');
        //echo "admin.inport";
        $ip = get_client_ip();

        //  echo $ip;
        if (!$_SESSION['admin_name']) { 
            echo "<script>alert('NOT LOAD!');window.location.href='index';</script>";
            $this->redirect('Login/index');
        }
        $this->redirect('admingl');
        $this->display();
    }

    public function admingl(){
      admin_check_session();
      $adminlist = M('iadmin')->select();
        $this->assign('adminlist',$adminlist);    //管理人员列表
        $this->display();
    }

    //个人信息管理开始----------------------------------------------------
    public function grxxgl($page=1,$pagesize=20){
        admin_check_session();
        $mapadmin['iname'] = $_SESSION['admin_name'];
        $iadminuse = M('iadmin')->where($mapadmin)->field('ipagesize')->find();
        $pagesize = $iadminuse['ipagesize'];

        if(!$page){
            $page=1;
        }

        $map['istat']=array('egt',0);//学生状态为0
        $haveget = 0;
        if(!empty($_GET['iname'])){
            $map['iname'] = array('like','%'.$_GET['iname'].'%');
            $haveget = 1;
        }else if(!empty($_GET['ixm'])){
            $map['ixm'] = array('like','%'.$_GET['ixm'].'%');
            $haveget = 1;
        }

        $db = M('iuser');
        $count = $db->where($map)->order('id desc')->count();
        if($haveget == 1){
            $page = 1;
            $pagesize = $count;
        }

        $pagenum = $count / $pagesize;
        if(floor($pagenum) != $pagenum){
            $pagenum = (int )$pagenum+1;
        }
        if($page>$pagenum){
            $page = $pagenum;
        }
        $data = $db->where($map)->page($page,$pagesize)->order('id desc')->select();

        $this->iuser = $data;       //查询结果
        $this->pagenum = $pagenum;  //分页数
        $this->page = $page;        //当前页数
        $this->pagesize = $pagesize;//每页显示数

        $this->display();

    }

    //删除某个考生的信息
    public function shanchu(){
        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        if(isset($_POST['do_tuihui'])) {
            $given_username = $_POST['iname'];
            $map['iname'] = $given_username;
            $dell = M('iupload')->where($map)->delete();
            $iuser = M('iuser')->where($map)->delete();
            if($iuser){

                $resp['accessGranted'] = true;
            }else{

                $resp['accessGranted'] = false;
            }
        }
        echo json_encode($resp);
    }
    //退回考生信息
    public function tuihui(){
        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        if(isset($_POST['do_tuihui'])) {
            $given_username = $_POST['iname'];
            $map['iname'] = $given_username;
            $data['istat'] = 1;
            $iuser = M('iuser')->where($map)->save($data);
            if($iuser){

                $resp['accessGranted'] = true;
            }else{

                $resp['accessGranted'] = false;
            }
        }
        echo json_encode($resp);
    }




    //个人信息结束-----------------------------------------------










    //材料审核管理开始----------------------------------------
    public function clshgl($page=1,$pagesize=20){
        admin_check_session();
        $mapadmin['iname'] = $_SESSION['admin_name'];
        $iadminuse = M('iadmin')->where($mapadmin)->field('ipagesize')->find();
        $pagesize = $iadminuse['ipagesize'];
        if(!$page){
            $page=1;
        }
        $map['istat']=array('in','2,3,4,5,6,7');
        $haveget = 0;
        if(!empty($_GET['iname'])){
            $map['iname'] = array('like','%'.$_GET['iname'].'%');
            $haveget = 1;
        }else if(!empty($_GET['ilb'])){
            $map['icmajor'] = array('like','%'.$_GET['ilb'].'%');
            $haveget = 1;
        }
        else if(!empty($_GET['ixm'])){
            $map['ixm'] = array('like','%'.$_GET['ixm'].'%');
            $haveget = 1;
        }
        $db = M('iuser');

        $count = $db->where($map)->count();
        if($haveget == 1){
            $page = 1;
            $pagesize = $count;
        }
        $pagenum = $count / $pagesize;
        if(floor($pagenum) != $pagenum){
            $pagenum = (int )$pagenum+1;
        }
        if($page>$pagenum){
            $page = $pagenum;
        }
        
        $data = $db->where($map)->page($page,$pagesize)->order('icmajor asc,id asc')->select();

        $imjn[1]='A';
        $imjn[2]='B';
        $imjn[3]='C';
        $imjn[4]='D';
        $this->imjn = $imjn;
        $this->iuser = $data;       //查询结果
        $this->pagenum = $pagenum;  //分页数
        $this->page = $page;        //当前页数
        $this->pagesize = $pagesize;//每页显示数

        $this->display();

    }

    public function cltx(){
        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        if(isset($_POST['do_xiugai'])) {
            $given_username = $_POST['name'];
            $give_stat   = $_POST['stat'];
            $give_val = $_POST['checked'];
            $map['iname'] = $given_username;
            if($give_stat == 1){
                $data['ishjl'] = $give_val; 
            }else if($give_stat == 0){
                $data['iahavesj'] = $give_val; 
            }

            $iuser = M('iuser')->where($map)->save($data);
            if($iuser){

                $resp['errors'] = '操作成功!';
                $resp['accessGranted'] = true;
            }else{

                $resp['errors'] = '操作失败!';
                $resp['accessGranted'] = false;
            }
        }

        // $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        echo json_encode($resp);
    }
    public function clsh(){
        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        if(isset($_POST['do_xiugai'])) {
            $given_username = $_POST['name'];
            $give_stat   = $_POST['stat'];
            $map['iname'] = $given_username;
            if($give_stat == 1)
                $data['istat'] = 5;
            else if($give_stat == 0)
                $data['istat'] = 2;
            else if($give_stat == 7)
                $data['istat'] = 6;
            else if($give_stat == 2)
                $data['istat'] = 4;


            $iuser = M('iuser')->where($map)->save($data);
            if($iuser){

                $resp['errors'] = '操作成功!';
                $resp['accessGranted'] = true;
            }else{

                $resp['errors'] = '操作失败!';
                $resp['accessGranted'] = false;
            }
        }

        // $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        echo json_encode($resp);
    }

    public function clshall(){
        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        if(isset($_POST['do_xiugai'])) {
            $getiname = $_POST['checked'];
            $given_username = explode(",",$getiname);
            $getnub = count($given_username);
            $give_stat = $_POST['stat'];

            if($getiname != ''){

                if($give_stat == 3)
                    $data['istat'] = 5;
                else if($give_stat == 4)
                    $data['istat'] = 2;
                else if($give_stat == 5)
                    $data['istat'] = 6;
                else if($give_stat == 6)
                    $data['istat'] = 4;

                $j = 0;
                for($i = 0 ; $i < $getnub ;$i++){
                    $cliname = $given_username[$i];
                    $map['iname'] = $cliname;
                    $iuser = M('iuser')->where($map)->save($data);
                    if($iuser){
                        $j++;
                    }
                }
                $resp['errors'] =   '操作成功!';
                $resp['accessGranted'] = true;
            }else{
                $resp['errors'] =   '请选择';
                $resp['accessGranted'] = true;
            }
        }

        // $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response


        echo json_encode($resp);
    }

    //材料审核结束----------------------------







    //专家审核开始-----------------
    public function zjshgl($page=1,$pagesize=20){
      admin_check_session();
      $mapadmin['iname'] = $_SESSION['admin_name'];
      $iadminuse = M('iadmin')->where($mapadmin)->field('ipagesize')->find();
      $pagesize = $iadminuse['ipagesize'];
      if(!$page){
        $page=1;
    }
    $map['istat']=array('in','4,5,6,7,8');
    $haveget = 0;
    if(!empty($_GET['iname'])){
        $map['iname'] = array('like','%'.$_GET['iname'].'%');
        $haveget = 1;
    }else if(!empty($_GET['ilb'])){
            $map['icmajor'] = array('like','%'.$_GET['ilb'].'%');
            $haveget = 1;
        }
    else if(!empty($_GET['ixm'])){
        $map['ixm'] = array('like','%'.$_GET['ixm'].'%');
        $haveget = 1;
    }
    $db = M('iuser');
    $count = $db->where($map)->count();
    if($haveget == 1){
        $page = 1;
        $pagesize = $count;
    }
    $pagenum = $count / $pagesize;
    if(floor($pagenum) != $pagenum){
        $pagenum = (int )$pagenum+1;
    }
    if($page>$pagenum){
        $page = $pagenum;
    }
    $data = $db->where($map)->page($page,$pagesize)->order('icmajor asc,id asc')->select();
    foreach($data as &$d)
    {
        
                  $d['isczm1']=M('iupload')->where("iname='".$d['iname']."' and irank=1")->select();
                   $d['isczm2']=M('iupload')->where("iname='".$d['iname']."' and irank=2")->select();
                    $d['isczm3']=M('iupload')->where("iname='".$d['iname']."' and irank=3")->select();
                     $d['isczm4']=M('iupload')->where("iname='".$d['iname']."' and irank=4")->select();
                      $d['isczm5']=M('iupload')->where("iname='".$d['iname']."' and irank=5")->select();
               //dump($a);
           
    }
    //dump($data);
    $imjn[1]='A';
    $imjn[2]='B';
    $imjn[3]='C';
    $imjn[4]='D';
    $this->imjn = $imjn;

        $this->iuser = $data;       //查询结果
        $this->pagenum = $pagenum;  //分页数
        $this->page = $page;        //当前页数
        $this->pagesize = $pagesize;//每页显示数
        $this->iup=$data2;
        $this->display();    }

  public function smtx(){//书面填写部分
        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        if(isset($_POST['do_xiugai'])) {
            $given_username = $_POST['name'];
            $give_stat   = $_POST['stat'];
            $give_val = $_POST['checked'];
            $map['iname'] = $given_username;
            if($give_stat == 0){
                $data['ibsjl'] = $give_val; 
            }

            $iuser = M('iuser')->where($map)->save($data);
            if($iuser){

                $resp['errors'] = '操作成功!';
                $resp['accessGranted'] = true;
            }else{

                $resp['errors'] = '操作失败!';
                $resp['accessGranted'] = false;
            }
        }

        // $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        echo json_encode($resp);
    }

    public function postbeizhu(){
        $msg = $_POST;

        dump($msg);
        foreach( $msg as $key => $value){
            $map['id'] = $key;
            if($value=='')
                continue;
            $data['ibsjl'] = $value;
            M('iuser')->where($map)->save($data);
        }
        $this->success('更新成功！');

    }

    //专家审核结束------------------



    //准考证号管理
    public function zkzhgl(){
      $pagesize=50;

      admin_check_session();

      $page = $_GET['page'];

      if(!$page){
        $page=1;
    }

    $major = $_GET['csmajor'];
    if(!$major){
        $major = 1;  

    }


        $map['istat']=array('egt',6);  //缴费后--istat > 6

        $haveget = 0;
        if(!empty($_GET['iname'])){
            $map['iname'] = array('like','%'.$_GET['iname'].'%');
            $haveget = 1;
        }else if(!empty($_GET['ixm'])){
            $map['ixm'] = array('like','%'.$_GET['ixm'].'%');
            $haveget = 1;
        }else{


            $map['icmajor'] = $major;
        }
        $db = M('iuser');
        $count = $db->where($map)->count();
        if($haveget == 1){
            $page = 1;
            $pagesize = $count;
        }
        $pagenum = $count / $pagesize;
        if(floor($pagenum) != $pagenum){
            $pagenum = (int )$pagenum+1;
        }
        if($page>$pagenum){
            $page = $pagenum;
        }

        $year =  date('Y', time());
        $data = $db->where($map)->page($page,$pagesize)->order('icqqh asc')->select();

        $mmaapp['id'] = array('neq',$major);
        $imajor = M('imajor')->where($mmaapp)->select();
        $map2['id'] = $major;
        $majorname = M('imajor')->where($map2)->find();

        $jor[1] = 'A';
        $jor[2] = 'B';
        $jor[3] = 'C';

        $this->assign('jor',$jor);
        $this->imajor = $imajor;
        $this->major = $major;
        $this->majorcs = $majorname;
        $this->iuser = $data;       //查询结果
        $this->pagenum = $pagenum;  //分页数
        $this->page = $page;        //当前页数
        $this->pagesize = $pagesize;//每页显示数

        $this->display();

    }
    //准考证号管理结束



    //分数管理
    public function fsgl($page=1,$pagesize=20){
        admin_check_session();

        $imajor = M('imajor')->select();
        foreach($imajor as $vo){
            $imj[$vo['id']] = $vo['mcode'];
        }
        $this->assign('imj',$imj);
        
        if(!$page){
            $page=1;
        }
        $map['istat']=array('egt',7);
        $haveget = 0;
        if(!empty($_GET['iname'])){
            $map['iname'] = array('like','%'.$_GET['iname'].'%');
            $haveget = 1;
        }else if(!empty($_GET['ilb'])){
            $map['icmajor'] = array('like','%'.$_GET['ilb'].'%');
            $haveget = 1;
        }
        else if(!empty($_GET['ixm'])){
            $map['ixm'] = array('like','%'.$_GET['ixm'].'%');
            $haveget = 1;
        }
        $db = M('iuser');
        $count = $db->where($map)->count();
        if($haveget == 1){
            $page = 1;
            $pagesize = $count;
        }
        $pagenum = $count / $pagesize;
        if(floor($pagenum) != $pagenum){
            $pagenum = (int )$pagenum+1;
        }
        if($page>$pagenum){
            $page = $pagenum;
        }
        $data = $db->where($map)->page($page,$pagesize)->select();

        $this->iuser = $data;       //查询结果
        $this->pagenum = $pagenum;  //分页数
        $this->page = $page;        //当前页数
        $this->pagesize = $pagesize;//每页显示数

        $this->display();

    }
    //分数管理结束

    //a个数证号管理
    public function agsgl($page=1,$pagesize=30){
      admin_check_session();
      if(!$page){
        $page=1;
    }
    $map['istat']=array('egt',2);
    $haveget = 0;
    if(!empty($_GET['iname'])){
        $map['iname'] = array('like','%'.$_GET['iname'].'%');
        $haveget = 1;
    }else if(!empty($_GET['ixm'])){
        $map['ixm'] = array('like','%'.$_GET['ixm'].'%');
        $haveget = 1;
    }
    $db = M('iuser');
    $count = $db->where($map)->count();
    if($haveget == 1){
        $page = 1;
        $pagesize = $count;
    }
    $pagenum = $count / $pagesize;
    if(floor($pagenum) != $pagenum){
        $pagenum = (int )$pagenum+1;
    }
    if($page>$pagenum){
        $page = $pagenum;
    }
    $data = $db->where($map)->page($page,$pagesize)->select();

        $this->iuser = $data;       //查询结果
        $this->pagenum = $pagenum+1;  //分页数
        $this->page = $page;        //当前页数
        $this->pagesize = $pagesize;//每页显示数

        $this->display();

    }
    //a个数管理结束
    //


    //----------------------------------------抽签
    public function fsdlgl(){
      admin_check_session();
      $fenzuarr;

      $imajor = M('imajor')->select();

      foreach($imajor as $vo){
        $mname = $vo['mname'];
        $mid = $vo['id'];
        $map['icmajor'] = $vo['id'];
        $map['istat'] = array('gt',6);

        $get = M('iuser')->where($map)->order('icqqh asc')->select();
        $fenzuarr[$mname] = $get;
    }
    $ffkd = '';

    $colffkd = 'btn-blue';
    $systemp = M('system')->limit(1)->find();
    $temppp = $systemp['scqkf'];
    if($temppp == 1){
        $ffkd = 'disabled';

        $colffkd = 'btn-primary';
    }else if($temppp == 2){
        $colffkd = 'btn-red';
    }
        //   var_dump($fenzuarr);
    $this->assign('colffkd',$colffkd);
    $this->assign('ffkd',$ffkd);
    $this->assign('fenzu',$fenzuarr);
    $this->assign('imajor',$imajor);
    $this->display();
}


    //生成抽签号
public function scqh(){
  admin_check_session();
  $imajor = M('imajor')->select();

  $datasys['scqkf'] = 2;
  $mapsys['id'] = 1;
  $ss = M('system')->where($mapsys)->save($datasys);
  $year =  date('Y', time());
  foreach($imajor as $vo){
    $maps['icmajor'] = $vo['id'];
    $maps['istat'] = array('gt',6);
    $card_num = M('iuser')->where($maps)->count();
    $cards = $this->wash_card($card_num);
    $iuser = M('iuser')->where($maps)->field('id')->select();
            //   $inamearr = $iuser->getField('iname');
            //  var_dump($iuser);
            // var_dump($cards);
    echo $card_num;
    echo "<br>";
    $iust = M('iuser');
    $tempu = $year.sprintf("%02d",0).$vo['mcode'];
    for($x = 0 ; $x < $card_num;$x++ ){
                // echo "<br>";
                // echo $x;
        $data['id'] = $iuser[$x]['id'];
        $data['icqqh'] = $cards[$x]+1;
        $izkzh =  $tempu.sprintf("%04d",$data['icqqh']);
        $data['izkzh'] = $izkzh; 
        $iust->save($data);
                //  var_dump($data); 
    }
}
        $resp = array('accessGranted' => false, 'errors' => '生成成功'); // For ajax response
      //  echo json_encode($resp);
    }
    //--------------------------------------------
    //----------------------tongzhi--start------------------

    public function tongzhigl(){
      admin_check_session();
      $fenzuarr;

      $imajor = M('notice')->select();
        //  var_dump($imajor);
      $this->assign('inotice',$imajor);
      $this->display();
  }

  public function gltongzhi(){

    $resp = array('accessGranted' => false, 'errors' => '操作失败'); 
    $do_what = $_POST['do_what'];
    $mid = $_POST['mid'];
    $res;

    $imajor = M('notice');
    $map['id'] = $mid;
    if($do_what == 'del'){
        $res = $imajor->where($map)->delete();
        if($res){
            $resp['accessGranted']=true;
            $resp['errors']='操作成功';
        }
    }else if ($do_what == 'tjupda') {
            # code...

        $data['title'] = $_POST['mname'];            
        $data['content'] = $_POST['mcontent']; 
        if($mid == ''){
            $res = $imajor->data($data)->add();
        }else{
            $res = $imajor->where($map)->save($data);
        }
        if($res){
            $resp['accessGranted']=true;
            $resp['errors']='操作成功';
        }
    }



    echo json_encode($resp);
}


    //----------------------tongzhi-----end-----------------




    //-----------------------major---start------------------




public function majorgl(){
  admin_check_session();
  $fenzuarr;

  $imajor = M('imajor')->select();
        //  var_dump($imajor);
  $this->assign('imajor',$imajor);
  $this->display();
}




public function glmajor(){
  admin_check_session();
  $resp = array('accessGranted' => false, 'errors' => '操作失败'); 
  $do_what = $_POST['do_what'];
  $mid = $_POST['mid'];
  $res;

  $imajor = M('imajor');
  $map['id'] = $mid;
  if($do_what == 'del'){
    $res = $imajor->where($map)->delete();
    if($res){
        $resp['accessGranted']=true;
        $resp['errors']='操作成功';
    }
}else if ($do_what == 'tjupda') {
            # code...

    $data['mcode'] = $_POST['mcode'];
    $data['mname'] = $_POST['mname'];            
    $data['mintro'] = $_POST['mintro']; 
    if($mid == ''){
        $res = $imajor->data($data)->add();
    }else{
        $res = $imajor->where($map)->save($data);
    }
    if($res){
        $resp['accessGranted']=true;
        $resp['errors']='操作成功';
    }
}



echo json_encode($resp);
}







    //-----------------------major---end------------------







public function charuser(){
    $userarr = M('iuser')->select();
    $this->display();
}








    //考生全部记录和按姓名或身份证查找某个学生的记录
public function ksxx(){
    $inixm = $_POST['ixm'];
    $ininame = $_POST['iname'];

    $map['istat'] = 0;

        //查找报名成功的学生信息

    if($ininame != ''){
        $map['iname'] = $ininame;
    }else if($inixm != ''){
        $map['ixm'] = $inixm;
    }

    $iuser = M('iuser')->where($map)->select();
        //$this->assign('iuser',$iuser);
    var_dump($iuser);
        //$this->display();
}

    //查看某个考生信息
public function seeoneinfo(){ 
    $iname = $_POST['iname'];
    $map['iname'] = $iname;
    $iuser = M('iuser')->where($map)->find();
    $this->assign('iuser',$iuser);
    var_dump($iuser);
}



    //材料审查
public function cailiao(){
    $iclstat  = $_POST['iclstat'];
    $iname = $_POST['iname'];
        // $id = $_POST['id'];
    $res = $this->cailiaobase($iname,$iclstat);
    if($res == 1){
        echo "审查成功";
    }else{
        echo "审查失败";
    }    
}


    //专家审查
public function zhuanjia(){
    $izjstat  = $_POST['izjstat'];
    $iname = $_POST['iname'];
        //$id = $_POST['id'];
    $res = $this->zhuanjiabase($iname,$izjstat);
    if($ews == 1){
        echo "专家审查成功";
    }else{
        echo "专家审查失败";
    }    
}


    //材料审查底层
function cailiaobase($iname,$iclstat){
    $data['iclstat'] = $iclstat;
    $map['iname'] = $iname;
    $iuser = M('iuser')->where($map)->save($data);
    if($iuser){
        return 1;
        echo "OOK";
    }else{ 
        return 0;
        echo "OOK";
    }
}

    //专家审查底层
function zhuanjiabase($iname,$izjstat){
    $data['izjstat'] = $izjstat;
    $map['iname'] = $iname;
    $iuser = M('iuser')->save($data);
    if($iuser){
        return 1;
    }else{ 
        return 0;
    }
}



    //洗牌算法

function wash_card($card_num) 
{ 
    $cards=$tmp=array(); 
    for($i=0;$i<$card_num;$i++){ 
        $tmp[$i]=$i; 
    } 

    for($i=0;$i<$card_num;$i++){ 
        $index=rand(0,$card_num-$i-1); 
        $cards[$i]=$tmp[$index]; 
        unset($tmp[$index]); 
        $tmp=array_values($tmp); 
    } 
    return $cards; 
}



    //直接导入不需要用到
    //快速排序使用
function quick_sort($arr)
{
        //判断参数是否是一个数组
    if(!is_array($arr)) return false;
        //递归出口:数组长度为1，直接返回数组
    $length=count($arr);
    if($length<=1) return $arr;
        //数组元素有多个,则定义两个空数组
    $left=$right=array();
        //使用for循环进行遍历，把第一个元素当做比较的对象
    for($i=1;$i<$length;$i++)
    {
            //判断当前元素的大小
        if($arr[$i]<$arr[0]){
            $left[]=$arr[$i];
        }else{
            $right[]=$arr[$i];
        }
    }
        //递归调用
    $left=quick_sort($left);
    $right=quick_sort($right);
        //将所有的结果合并
    return array_merge($left,array($arr[0]),$right);


}

}
