<?php
namespace Admin\Controller;
use Think\Controller;
class SystemController extends Controller {
	
	
	public function daorujf(){
        $rootuse  =     './Public/sysuse/'; // 设置附件上传根目录
        
        $path = $rootuse.'xxx.xls';

        vendor("PHPExcel.PHPExcel");
        $filename=$path;

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
            for($currentColumn=0;$currentColumn<= $haveColumn;$currentColumn++){
                //数据坐标
               $temp= \PHPExcel_Cell::StringFromColumnIndex($currentColumn); 
               $address=$temp.$currentRow;
                //读取到的数据，保存到数组$arr中
               $arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
           }
       }
       $ttem = 0;


      //  dump($arr);

       $recott = 0;
       foreach($arr as $value){
        $map['iorderNo'] = $value[1];
        $map['iisjf'] = 0;

        $iuser = M('iuser')->where($map)->find();
        if($iuser){
            echo $iuser['iname'].'  '.$value[1].'='.$iuser['iorderno'].' '.$value[5].' <br/>';


            $map2['iname'] = $iuser['iname'];
            $data['istat'] = 7;
            $data['iisjf'] = 1;
            $data['ijylsh'] = $value[5];
           // $iuser2 = M('iuser')->where($map2)->save($data);
            if($iuser2){
                $recott++;
            }

        }
    }

    echo $recott;
        //$this->success("共成功上传".$ttem."位数据");
}
	
	
	
    public function index(){
        echo "system chuli mokuai";
        $this->display();
    }

    public function tongjiA(){
        $iuser = M('iuser')->select();

        $xkkm = M('xkkm')->select();

        foreach($xkkm as $vo){
            $xk[$vo['id']] = $vo['hkdh'];
        }

        foreach($iuser as $vo){
            $sum = 0;
            foreach($xk as $dh){
                if($vo[$dh] == 'A'){
                    $sum++;
                }
            }
            $data['iahave'] = $sum;
            $map['iname'] = $vo['iname'];
            $u = M('iuser')->where($map)->save($data);
        
        }
        echo "HH";
    
    }
    public function shutdowncq(){

        $map['id'] = 1;
        $data['scqkf'] = 0;
        $iuser = M('system')->where($map)->save($data);
        $this->success("关闭抽签系统成功!");
    }
     public function startupcq(){

        $map['id'] = 1;
        $data['scqkf'] = 1;
        $iuser = M('system')->where($map)->save($data);
        $this->success("开放抽签系统成功!");
     }

    
    public function daorufs(){
        $rootuse  =     './Public/sysuse/'; // 设置附件上传根目录
        $Sysinfo = M('system')->limit(1)->find();
        $path = $rootuse.$Sysinfo['sysfs'];

         vendor("PHPExcel.PHPExcel");
        $filename=$path;

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
            for($currentColumn=0;$currentColumn<= $haveColumn;$currentColumn++){
                //数据坐标
               $temp= \PHPExcel_Cell::StringFromColumnIndex($currentColumn); 
               $address=$temp.$currentRow;
                //读取到的数据，保存到数组$arr中
               $arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
            }
        }
        $ttem = 0;
        foreach($arr as $value){
            $map['iname'] = $value[0];
            $data['iscore'] = $value[1];
            $data['iscopm'] = $value[2];
            $data['iscohg'] = $value[3];
         //   $map['ixm'] = $value[3];
            $iuser = M('iuser')->where($map)->save($data);
            if($iuser){
            $ttem++;
            }
        }
        $this->success("共成功上传".$ttem."位数据");
    }


    public function daorush(){
        $rootuse  =     './Public/sysuse/'; // 设置附件上传根目录
        $Sysinfo = M('system')->limit(1)->find();
        $path = $rootuse.$Sysinfo['sysags'];
         vendor("PHPExcel.PHPExcel");
        $filename=$path;

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
            for($currentColumn=0;$currentColumn<= $haveColumn;$currentColumn++){
                //数据坐标
               $temp= \PHPExcel_Cell::StringFromColumnIndex($currentColumn); 
               $address=$temp.$currentRow;
                //读取到的数据，保存到数组$arr中
               $arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
            }
        }
        $ttem = 0;
        foreach($arr as $value){
            $map['iname'] = $value[0];
            $data['istat'] = $value[1];
            $data['ishjl'] = $value[2];
            $data['ibsjl'] = $value[3];
         //   $map['ixm'] = $value[3];
            $iuser = M('iuser')->where($map)->save($data);
            if($iuser){
            $ttem++;
            }
        }
        $this->success("共成功上传".$ttem."位数据");
    }

    //上传分数
    public function uploadags(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls');// 设置附件上传类型
        $upload->rootPath  =     './Public/sysuse/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error('上传失败');
        }else{// 上传成功 获取上传文件信息
            $savepath = $info['photo']['savepath'];
            $savename = $info['photo']['savename'];
            $pic = $savepath.$savename;
            $map['id'] = 1;
            $data['sysags'] = $pic;
            $iuser = M('system')->where($map)->save($data);
            if($iuser){
                $this->success('上传成功!');
            }else{
                $this->error('上传失败');
            }
        }
    }
    
    public function daoruags(){
        $rootuse  =     './Public/sysuse/'; // 设置附件上传根目录
        $Sysinfo = M('system')->limit(1)->find();
        $path = $rootuse.$Sysinfo['sysags'];

         vendor("PHPExcel.PHPExcel");
        $filename=$path;

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
            for($currentColumn=0;$currentColumn<= $haveColumn;$currentColumn++){
                //数据坐标
               $temp= \PHPExcel_Cell::StringFromColumnIndex($currentColumn); 
               $address=$temp.$currentRow;
                //读取到的数据，保存到数组$arr中
               $arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
            }
        }
        $ttem = 0;
        foreach($arr as $value){
            $map['iname'] = $value[0];
            //$data['iahavesj'] = $value[1];
            $data['iahaveksy'] = $value[2];
         //   $map['ixm'] = $value[3];
            $iuser = M('iuser')->where($map)->save($data);
            if($iuser){
            $ttem++;
            }
        }
        $this->success("共成功上传".$ttem."位数据");
    }

    //上传分数
    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls');// 设置附件上传类型
        $upload->rootPath  =     './Public/sysuse/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error('上传失败');
        }else{// 上传成功 获取上传文件信息
            $savepath = $info['photo']['savepath'];
            $savename = $info['photo']['savename'];
            $pic = $savepath.$savename;
            $map['id'] = 1;
            $data['sysags'] = $pic;
            $iuser = M('system')->where($map)->save($data);
            if($iuser){
                $this->success('上传成功!');
            }else{
                $this->error('上传失败');
            }
        }
    }
}
