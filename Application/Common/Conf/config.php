<?php
return array(


    //黙认分组设置
    'DEFAULT_MODULE' => 'Home', // 默认模块
    'MODULE_ALLOW_LIST' => array('Home', 'Admin',), //定义可供访问的分组列表

    /* 数据库配置设置 */
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => 'localhost', // 服务器地址
    'DB_NAME' => 'swyt2018', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => 'root', // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => 'swyt_', // 数据库表前缀
    'DB_PARAMS' => array(), // 数据库连接参数    
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志
   // 'DB_FIELDS_CACHE' => true, // 启用字段缓存
    'DB_CHARSET' => 'utf8', // 数据库编码默认采用utf8
   // 'URL_MODEL' => 2, // 智能模式
    'SHOW_PAGE_TRACE' => false, //页面底部显示跟踪信息 关闭 设为 false  开启  true
);
