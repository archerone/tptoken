<?php
if(strpos($_SERVER['SERVER_NAME'],'localhost:8080')){
  
}elseif(strpos($_SERVER['SERVER_NAME'],'localhost')){

}else{
  //ini_set('session.cookie_domain', ".hbiger.com");  //设置session对应cookie的起效域名
}
define('APP_DEBUG', true); 
// 默认绑定Home模块
//define('BIND_MODULE', 'Home');
define('APP_PATH','./');

require '../thinkphp_3.2.3_full/ThinkPHP/ThinkPHP.php';
