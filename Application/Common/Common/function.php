<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17-1-2
 * Time: 下午3:46
 */
 function getBrowser(){
     $agent=$_SERVER["HTTP_USER_AGENT"];
     if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
         return "ie";
     else if(strpos($agent,'Firefox')!==false)
         return "firefox";
     else if(strpos($agent,'Chrome')!==false)
         return "chrome";
     else if(strpos($agent,'Opera')!==false)
         return 'opera';
     else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
         return 'safari';
     else
         return 'unknown';
 }

function getBrowserVer(){
    if (empty($_SERVER['HTTP_USER_AGENT'])){    //当浏览器没有发送访问者的信息的时候
        return 'unknow';
    }
    $agent= $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs))
        return $regs[1];
    elseif (preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs))
        return $regs[1];
    elseif (preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs))
        return $regs[1];
    elseif (preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs))
        return $regs[1];
    elseif ((strpos($agent,'Chrome')==false)&&preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs))
        return $regs[1];
    else
        return 'unknow';
}


function gettabid($stat){
    $ret = 'hyxx';
    switch($stat){
    case 0:
    $ret = 'hyxx';
        break;
    case 1:
    $ret = 'kebm';
        break;
    case 2:
    $ret = 'ttxx';
        break;
    case 3:
    $ret = 'kesc';
        break;
    case 4:
    $ret = 'ttxx';
        break;
    case 5:
    $ret = 'ttxx';
        break;
    case 6:
    $ret = 'kejf';
        break;
    case 7:
    $ret = 'kejf';
        break;
    
    }
    return $ret;

}

function admin_check_session(){
        if (!$_SESSION['admin_name']) { 

                echo "<script>alert('未登录!');window.location.href='index';</script>";

               redirect('index');

        }


}
