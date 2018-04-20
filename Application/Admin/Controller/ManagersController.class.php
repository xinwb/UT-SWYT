<?php
namespace Admin\Controller;
use Think\Controller;

class ManagersController extends Controller{
	
	
	function daochucq(){
		 $name = "Content-Disposition:filename=zkkh.xls";

        $imajor = M('imajor')->select();
        foreach($imajor as $vo){
            $imj[$vo['id']] = $vo['mname'];
        }
        $map[istat] = 7;
		$map[iisjf] = 1;
		

        $name = str_replace('zkkh','抽签情况',$name);
        header("Content-type:application/vnd.ms-excel");
        header($name);
        $u = M('iuser')->where($map)->order('iwecq asc')->select();
		
		$icmajor[1] = 'A';
		$icmajor[2] = 'B';
		$icmajor[3] = 'C';
		$icqqk['haha'] = '已抽签';
		$this->assign('imajor',$icmajor);
		$this->assign('icqqk',$icqqk);
        $this->assign('imj',$imj);
        $this->assign('u',$u);
        $html = $this->fetch();
        echo $html;
        exit;
		
	}
	function newjfdo(){
        if(IS_POST){
            $orderNo = $_POST['iorderno'];
            $ordermap['iorderNo'] = $orderNo;
            $orderNolist = M('ordercode')->where($ordermap)->select();

            $iname = '';
            $num = 0;
            echo $orderNo.'<br/>';
            foreach ($orderNolist as $value) {
                # code...
                echo $value['iname'].'  '.$value['iorderno'].'<br/>';
                $iname = $value['iname'];
                $num++;
            }

            $orderNolistmap2['iname'] = $iname;

            $orderNolist2 = M('ordercode')->where($orderNolistmap2)->select();

            echo '<br/><br/><br/>';
            foreach ($orderNolist2 as  $value) {
                # code...
                echo $value['iname'].'  '.$value['iorderno'].'<br/>';
            }



            echo $num.'##<br/>';

            if($iname){
                $iusermap['iname'] = $iname;
                $iuserlist = M('iuser')->where($iusermap)->select();
                var_dump($iuserlist);
                $iuserlist = $iuserlist[0];
                echo '<br/><br/><br/>';
                echo $iuserlist['iname'].' '.$iuserlist['istat'].' '.$iuserlist['iorderno'].' '.$iuserlist['iisjf'].'<br/>';
            }


        }else{
            echo 'NO';
        }

            $this->display();
    }
	
	function countjf(){

        $iisermap['iisjf'] = 1;
        $have = M('iuser')->where($iisermap)->count();
        echo $have;
    }
	
	
	 function jfinputdo(){
		 exit;
        if(IS_POST){
            $ordernub = $_POST['iiname'];
            

            $map['iname'] =  $ordernub;
            $map['istat'] = 6;
            $data['istat'] = 7;
            $data['iisjf'] = 1;
			$data['iorderNo'] = $_POST['orderoo']; 
            $iuser = M('iuser')->where($map)->save($data);
            if($iuser){
                $this->success("成功");
            }
            
        }else{
            echo 'NO';
        }
       // $this->display();
    }


     function jfinput(){

        if(IS_POST){
            $ordernub = $_POST['ordernub'];
            $str = substr($ordernub, 8,4);

            $map['iname'] =  array('like',"%$str");
            $map['istat'] = array('in',array(6,7));;
            $iuser = M('iuser')->where($map)->select();
            foreach($iuser as $vo){
                echo $vo['iname'].' '.$vo['istat'].' '.$vo['iorderno'].'<br/>';
            }
            $have = count($iuser);
            echo $have.'=='.$ordernub.' '.$str.'<br/>';
        }else{
            echo 'NO';
        }
        $this->display();
    }

    function index(){
        $id = session('id');
        //if($id){
        $nowuser = M('iadmin')->where('id = 1')->field('itype')->find();
        //echo var_dump($nowuser['itype']);
        //}
        $adminlist = M('iadmin')->select();
        $this->assign('adminlist',$adminlist);
        $this->display();
    }
    public function agsdc($se = 0){//a个数导出
        $majorn = M('xkkm')->select();
        foreach($majorn as $vo){
            $majoruse[$vo['id']] = $vo['kmname'];
            $tg[$vo['id']] = '通过';
        }
        $imajor = M('imajor')->select();
        foreach($imajor as $vo){
            $imj[$vo['id']] = $vo['mname'];
        }
        $tg[0]= '未通过';
        $tg[2]= '未通过';
        $tg[3]= '未通过';
        $tg[1]= '未通过';
        if($se == 0){//全部 
            $title='A个数全部信息';
        }

        $titleuse = "Content-Disposition:filename=tttt.xls"; 
        $title =  str_replace("tttt",$title,$titleuse);

        header("Content-type:application/vnd.ms-excel");
        header($title);

        $u = M('iuser')->order('istat asc')->select();
        $this->assign('majorn',$majoruse);
        $this->assign('u',$u);
        $this->assign('imj',$imj);
        $this->assign('tg',$tg);
        $html = $this->fetch();
        echo $html;
        exit;

        // $this->display();
    }

    public function fsdc($se = 0){//分数导出
        $majorn = M('xkkm')->select();
        foreach($majorn as $vo){
            $majoruse[$vo['id']] = $vo['kmname'];
            $tg[$vo['id']] = '通过';
        }
        $imajor = M('imajor')->select();
        foreach($imajor as $vo){
            $imj[$vo['id']] = $vo['mname'];
        }
        $tg[0]= '未通过';
        $tg[2]= '未通过';
        $tg[3]= '未通过';
        $tg[1]= '未通过';
        if($se == 0){//全部 
            $map['istat']=array('in','7');
            $title = '分数导出';
        }
        $titleuse = "Content-Disposition:filename=tttt.xls"; 
        $title =  str_replace("tttt",$title,$titleuse);

        header("Content-type:application/vnd.ms-excel");
        header($title);

        $u = M('iuser')->where($map)->order('istat asc')->select();
        $this->assign('majorn',$majoruse);
        $this->assign('u',$u);
        $this->assign('imj',$imj);
        $this->assign('tg',$tg);
        $html = $this->fetch();
        echo $html;
        exit;

        // $this->display();
    }

    public function smdc($se = 0){//书面导出
        $majorn = M('xkkm')->select();
        foreach($majorn as $vo){
            $majoruse[$vo['id']] = $vo['kmname'];
            $tg[$vo['id']] = '通过';
        }
        $imajor = M('imajor')->select();
        foreach($imajor as $vo){
            $imj[$vo['id']] = $vo['mname'];
        }
        $tg[0]= '未通过';
        $tg[2]= '未通过';
        $tg[3]= '未通过';
        $tg[1]= '未通过';
        $tg[4]= '未通过';
        $tg[5]= '未审核';
		
        if($se == 0){//全部 
            $map['istat']=array('in','4,5,6,7');
            $title='书面评审全部信息';
        }else if($se == 1){//通过 
            $map['istat']=array('in','6,7');
            $title='书面评审通过全部信息';
        }else if($se == 2){//不通过

            $map['istat']=array('in','4,5');
            $title='书面评审未通过全部信息';
        }

        $titleuse = "Content-Disposition:filename=tttt.xls"; 
        $title =  str_replace("tttt",$title,$titleuse);

        header("Content-type:application/vnd.ms-excel");
        header($title);

		
        $u = M('iuser')->where($map)->order('istat asc')->select();
        
		$icmajor[1] = 'A';
		$icmajor[2] = 'B';
		$icmajor[3] = 'C';
		
		$this->assign('imajor',$icmajor);
		$this->assign('majorn',$majoruse);
        $this->assign('u',$u);
        $this->assign('imj',$imj);
        $this->assign('tg',$tg);
        $html = $this->fetch();
        echo $html;
        exit;

        // $this->display();
    }

    public function cldc($se = 0){//材料导出
        $majorn = M('xkkm')->select();
        foreach($majorn as $vo){
            $majoruse[$vo['id']] = $vo['kmname'];
            $tg[$vo['id']] = '通过';
        }
        $imajor = M('imajor')->select();
        foreach($imajor as $vo){
            $imj[$vo['id']] = $vo['mname'];
        }
        $tg[0]= '未通过';
        $tg[2]= '未通过';
        $tg[3]= '未审核';
        $tg[1]= '未通过';
        if($se == 0){//全部 
            $map['istat']=array('in','2,3,5,4,6,7');
            $title='材料审核全部信息';
        }else if($se == 1){//通过 
            $map['istat']=array('in','4,5,6,7');
            $title='材料审核通过全部信息';
        }else if($se == 2){//不通过

            $map['istat']=array('in','2,3');
            $title='材料审核未通过全部信息';
        }

        $titleuse = "Content-Disposition:filename=tttt.xls"; 
        $title =  str_replace("tttt",$title,$titleuse);

        header("Content-type:application/vnd.ms-excel");
        header($title);

        $u = M('iuser')->where($map)->order('istat asc')->select();
        $this->assign('majorn',$majoruse);
        $this->assign('u',$u);
        $this->assign('imj',$imj);
        $this->assign('tg',$tg);
        $html = $this->fetch();
        echo $html;
        exit;

        // $this->display();
    }


    public function dczkzh(){

        $majorn = M('xkkm')->select();
        foreach($majorn as $vo){
            $majoruse[$vo['id']] = $vo['kmname'];
        }
        $time = date("Y-m-d-H:i:s", time());
        $name = "Content-Disposition:filename=zkkh.xls";
        $name = str_replace('zkkh',$time,$name);
        header("Content-type:application/vnd.ms-excel");
        header($name);
         $map['istat'] = array('egt','6');
        $u = M('iuser')->where($map)->order('izkzh asc')->select();
		$icmajor[1] = 'A';
		$icmajor[2] = 'B';
		$icmajor[3] = 'C';
		
		$this->assign('imajor',$icmajor);
        $this->assign('majorn',$majoruse);
        $this->assign('u',$u);
        $html = $this->fetch();
        echo $html;
        exit;
    }
    public function dcwjf($se = 0){
        // $time = date("Y-m-d-H:i:s", time());
        $name = "Content-Disposition:filename=zkkh.xls";

        $imajor = M('imajor')->select();
        foreach($imajor as $vo){
            $imj[$vo['id']] = $vo['mname'];
        }
        if($se == 0){
            $map['istat'] = 6;
            $time = '未缴费';
        }else if($se == 1){

            $time = '已缴费';
            $map['istat'] = 7;
        }


        $name = str_replace('zkkh',$time,$name);
        header("Content-type:application/vnd.ms-excel");
        header($name);
        $u = M('iuser')->where($map)->order('izkzh asc')->select();
		
			$icmajor[1] = 'A';
		$icmajor[2] = 'B';
		$icmajor[3] = 'C';
		
		$this->assign('imajor',$icmajor);
        $this->assign('uset',$time);
        $this->assign('imj',$imj);
        $this->assign('u',$u);
        $html = $this->fetch();
        echo $html;
        exit;
    }
    public function dcxsxx(){
    
        $majorn = M('xkkm')->select();
        foreach($majorn as $vo){
            $majoruse[$vo['id']] = $vo['kmname'];
            $tg[$vo['id']] = '通过';
        }
        $imajor = M('imajor')->select();
        foreach($imajor as $vo){
            $imj[$vo['id']] = $vo['mname'];
        }

        $title = '全部学生信息';
        $titleuse = "Content-Disposition:filename=tttt.xls"; 
        $title =  str_replace("tttt",$title,$titleuse);

        header("Content-type:application/vnd.ms-excel");
        header($title);

        $u = M('iuser')->where($map)->order('istat asc')->select();
        $this->assign('majorn',$majoruse);
        $this->assign('u',$u);
        $this->assign('imj',$imj);
        $html = $this->fetch();
        echo $html;
        exit;
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=全部学生信息.xls");
        $u = M('iuser')->select();
        $this->assign('u',$u);
        $html = $this->fetch();
        echo $html;
        exit;
    }
    public function edit($id = 0) {
        if (!empty($_POST)) {
            //实例化model类

            $mod = M('iadmin');
            //将数据插入数据库中
            //$data['id'] = $_POST['id'];
            $iadmin = new \Admin\Model\IadminModel();
            $data['id'] = $iadmin->getId($_POST['iname']);
            $data['iname'] = $_POST['iname'];
            $data['ipwd'] = $_POST['ipwd'];
            $data['ixm'] = $_POST['ixm'];
            $data['iphone'] = $_POST['iphone'];
            $data['ipagesize'] = $_POST['ipagesize'];
            $list = $mod->save($data);
            if (!$list) {
                $this->error("修改失败 请重新操作!", U('index/admingl'));
            } else {
                $this->success("修改成功", U('index/admingl'));
            }
        }
        //展示表单
        $admin = M('iadmin');
        $info = $admin->where('id=" ' . $id . ' "')->find();
        $this->assign('info', $info);
        $this->display();
    }

    public function dec() {


        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax response
        if(isset($_POST['do_tuihui'])) {
            $id = $_POST['iname'];
            $res = M('iadmin')->delete($id);
            if($res){

                $resp['accessGranted'] = true;
            }else{

                $resp['accessGranted'] = false;
            }
        }
        echo json_encode($resp);

    }


    public function add(){

        $resp = array('accessGranted' => false, 'errors' => ''); // For ajax respons

        if(isset($_POST['do_add'])) {
            //dump($_POST);exit;
            $admin = $_POST['adminname'];
            //查询所有的用户的账号
            $list = M('iadmin')->field('iname')->select();
            // dump($list);exit;
            //定义一个数组
            $arr = array();
            //遍历所有的用户
            foreach ($list as $v) {
                $arr[] = $v['iname'];
            }
            //判断是否存在相同的账号
            if (in_array($admin, $arr)) {
                $resp['accessGranted'] = false;
                $resp['errors']='己存在相同登录名的管理员 请更换后在添加!';
                //window.location.href='admin_add';
            } else {
                //实例化model类
                $mod = M('iadmin');
                //将数据插入数据库中
                $data['iname'] = $_POST['adminname'];
                $data['ipwd'] = $_POST['adminpwd'];
                $data['ixm'] = $_POST['adminxm'];
                $data['iphone'] = $_POST['iphone'];
                $data['itxt'] = "WHT";
                $data['itype'] = 1;
                $data['itime'] = date('Y-m-d H:i:s', time());
                // dump($data);exit;
                $list = $mod->data($data)->add();

                if (!$list) {
                    $resp['accessGranted'] = false;
                    $resp['errors']='添加失败 请重新操作!';

                } else {
                    //$this->success("添加成功");
                    $resp['accessGranted'] = true;
                    $resp['errors']='添加成功!';

                }
            }
        }

        echo json_encode($resp);

    }

    function ceshidaoru(){
        vendor("PHPExcel.PHPExcel");
        $filename="./Public/cc2.xls";

        $PHPExcel = new \PHPExcel();
        $PHPReader=new \PHPExcel_Reader_Excel5();
        $PHPExcel = $PHPReader->load($filename);

        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet=$PHPExcel->getSheet(0);
        //获取总列数
        $allColumn=$currentSheet->getHighestColumn();
        //获取总行数
        $allRow=$currentSheet->getHighestRow();
        $haveColumn = \PHPExcel_Cell::columnIndexFromString($allColumn);
        // var_dump($currentSheet);
        for($currentRow=2;$currentRow<=$allRow;$currentRow++){
            //从哪列开始，A表示第一列
            for($currentColumn=1;$currentColumn<= $haveColumn;$currentColumn++){
                //数据坐标
                $temp= \PHPExcel_Cell::StringFromColumnIndex($currentColumn); 
                $address=$temp.$currentRow;
                //读取到的数据，保存到数组$arr中
                $arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
            }
        }
        dump($arr);
        foreach($arr as $value){
            $data['iname'] = $value[1];
            $data['icsmajor'] = $value[2];
            $data['izkkh'] = $value[3];
            $data['igkxh'] = $value[4];
            $data['ixm'] = $value[5];
            $data['ixb'] = $value[6];
            $data['icssj'] = $value[7];
            $data['ilb'] = $value[8];
            $data['imz'] = $value[9];
            $data['ihkzh'] = $value[10];
            $data['izzmm'] = $value[11];
            $data['iemail'] = $value[12];
            $data['imobile'] = $value[13];
            $data['itel'] = $value[14];
            $data['iaddr'] = $value[15];
            $data['iybcode'] = $value[16];
            $data['ibyzx'] = $value[17];
            $data['ibyaddr'] = $value[18];
            $data['ibycode'] = $value[19];
            $data['ibyteac'] = $value[20];
            $data['ibytetel'] = $value[21];
            $data['ibytel'] = $value[22];
            $data['ials'] = $value[23];
            $data['iadl'] = $value[24];
            $data['iaxx'] = $value[25];
            $data['iayy'] = $value[26];
            $data['iawl'] = $value[27];
            $data['iahx'] = $value[28];
            $data['iasz'] = $value[29];
            $data['iasw'] = $value[30];
            $data['iajs'] = $value[31];
            $data['iayw'] = $value[32];
            $data['iasx'] = $value[33];
            $data['iazx'] = $value[34];
            $data['iscore'] = $value[35];
            $data['iscore1'] = $value[36];
            $data['iscohg'] = $value[37];
            $data['iscopm'] = $value[38];

            //   $iuser = M('iuser')->data($data)->add();
            if($user){
                echo "OK";
            }
        }
    }


}
