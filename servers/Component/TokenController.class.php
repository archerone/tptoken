<?php
namespace Component;
use Think\Controller;
vendor('Firebase.JWT.JWT');
use \Firebase\JWT\JWT;
class TokenController extends Controller {
    //构造方法:实现各个方法访问过滤效果
    function __construct(){
       parent::__construct();
       header('Content-Type:text/html;charset=utf-8');
       if($_SERVER['HTTP_HOST'] == 'localhost'){
          header('Access-Control-Allow-Origin: http://localhost:8080'); //本地测试,注意index.php内设置的session.cookie_domain
        }else{
          header('Access-Control-Allow-Origin: http://vue.hbiger.com');
        }
        header('Access-Control-Allow-Credentials: true'); //让ajax可以接受后端的setCookie
        header('Access-Control-Max-Age: 3600');           //Access-Control-Max-Age来控制浏览器在多长时间内（单位s）无需在请求时发送预检请求
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");  //让跨域请求可以接受post的方式
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

       //每次请求过来检查token
       if(  C('TOKEN_ON') && !in_array( CONTROLLER_NAME,explode(',',C('NOT_TOKEN_CONTROLLER')) )  ){
        
             $headers=getallheaders();
             $httpAuthorization = $headers['Authorization'];
             $arr = explode(" ",$httpAuthorization);
             $jwt = $arr[1];
             if(empty($arr) || empty($jwt)){
                echo '未登录';exit;
             }
             else{
                JWT::$leeway = 60;//当前时间减去60，把时间留点余地
                $key = "hueritmnbzcop3158671";
                $decoded = JWT::decode($jwt, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
                $arr = (array)$decoded;
                if(!empty($arr['type'])){ //如果验证未通过
                    print_r($arr['msg']);exit;
                }else{
                    
                }
             }
       }
       


    }
}