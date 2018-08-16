<?php
return array(
	//'配置项'=>'配置值'
	"SHOW_PAGE_TRACE" => false,
	/* 数据库设置 */
    'DB_TYPE'               =>  'mysql',         // 数据库类型
    'DB_HOST'               =>  '106.14.161.71', // 服务器地址
    'DB_NAME'               =>  'arvue',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'tSLCWcDUZSXx',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  '',       // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数    
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
    'COO_KIE'               =>  'asd23123~$^opi',
    //'COOKIE_DOMAIN'         => '.hbiger.com',  //设置cookie时的起效域名
    //修改模板引擎为smarty
    //'TMPL_ENGINE_TYPE'      =>  'Smarty'
    'DATA_CACHE_TYPE'       =>  'File',  // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
    'SESSION_OPTIONS'         =>  array(  
                           'name'  =>  'BLSESSION',                           //设置session名     
                           'expire'        =>  1440,                           //SESSION过期时间，单位秒    
                            'use_trans_sid'       =>  0,                       //跨页传递    
                            'use_only_cookies'    =>  1                        //是否只开启基于cookies的session的会话方式    
                            ),

    
);