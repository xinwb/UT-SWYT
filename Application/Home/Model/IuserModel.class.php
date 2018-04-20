<?php

namespace Home\Model;

use Think\Model;

/**
  @时间：2016-11-19
  @模块：管理员账号与密码验证
 */
class IuserModel extends Model {

    //用户名和密码校验
    function checkNamePwd($name, $pass) {
        //1 根据 $name 确认名字是否存在 
        $info = $this->where("iname='$name'")->find();
        //dump($info);//有结果返回结果的记录信息，没有返回null
        // 2 如果$name的记录存在，就让记录的密码和 $pass 做比较
        if ($info) {
            if ($info['ipwd'] === $pass)
                return $info;
        }
        return null;
    }
    function getId($name){
        $info = $this->where("iname='$name'")->find();
        $id = $info['id'];
        return $id;

    }

    protected $_validate = array(
   // array('verify','require','验证码必须！'), //默认情况下用正则进行验证
    array('iname','','帐号名称已经存在！',0,'unique',1),// 在新增的时候验证name字段是否唯一
    //array('value',array(1,2,3),'值的范围不正确！',2,'in'), // 当值不为空的时候判断是否在一个范围内
    //array('repassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
    //array('password','checkPwd','密码格式不正确',0,'function'), // 自定义函数验证密码格式
);
    

}