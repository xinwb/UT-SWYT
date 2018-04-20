<?php

namespace Admin\Model;

use Think\Model;

/**
   @时间：2016-11-19
  @模块：管理员账号与密码验证
 */
class IadminModel extends Model {

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

}