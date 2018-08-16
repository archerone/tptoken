<?php
namespace Home\Controller;
use Component\TokenController;
vendor('Firebase.JWT.JWT');
use \Firebase\JWT\JWT;
class UserController extends TokenController {
	public function yzm(){
      $verify = new \Think\Verify();
    	$verify->entry();
	}
    public function login(){
    	if(IS_POST){
          $uname = I('post.uname');
	    	  $pwd = I('post.upasswd');

	        $verify = new \Think\Verify();
	        $code = I('post.yzm');
          //验证时注意index.php内设置的session.cookie_domain
	        if(!$verify->check($code)){
	           $data = array(
                    'info' => '验证码错误',
                    'res' =>100 
               );
               $this->ajaxReturn($data);
               exit;
	        }

	        $userModel = D('user');
	        $userinfo = $userModel->where(array('uname'=>$uname))->find();
	        if(!$userinfo){
	           $data = array(
                    'info' => '用户名不存在',
                    'res' =>101 
               );
	        }
	        if($userinfo['upasswd']!==$pwd){
               $data = array(
                    'info' => '密码错误',
                    'res' =>102 
               );
	        }else{
               //$coo_kie = $this->jm($userinfo['uid'].$userinfo['uname'].C('COO_KIE'));
	             //cookie('uname',$userinfo['uname'],1440);
               //cookie('utoken',$coo_kie,1440);
               /*strpos($_SERVER['HTTP_REFERER'],'localhost')?$httpurl="":$httpurl=".hbiger.com";
               cookie('uname',$userinfo['uname'],'expire=1440&domain='.$httpurl);
               if(strpos($_SERVER['HTTP_REFERER'],'localhost')){
                  session('uname',$userinfo['uname']);
               }else{
                  session(array('name'=>'uname','domain'=>'.hbiger.con'),$userinfo['uname']);
               }*/
               //jwt
                   $t = time();
                   $token = array(
                      "iss" => "bms",
                      "aud" => "api.beimsn.com",

                      "iat" => $t,
                      'nbf' => $t,
                      'data' => [ 
                          'userid' => $userinfo['uid'],
                          'username' => $userinfo['uname']
                      ]
                   );
                   $access_token = $token;
                   $access_token['scopes'] = 'role_access'; //token标识，请求接口的token
                   $access_token['exp'] = $t+C('TOKEN_TIME');

                   $refresh_token = $token;
                   $refresh_token['scopes'] = 'role_refresh'; //token标识，刷新access_token
                   $refresh_token['exp'] = $t+(86400 * 7);   //access_token过期时间,这里设置7天

                   /*$jsonList = [
                     'access_token'=>JWT::encode($access_token,C('TOKEN_KEY')),
                     'refresh_token'=>JWT::encode($refresh_token,C('TOKEN_KEY')),
                     'token_type'=>'bearer' //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
                   ];*/
                   Header("HTTP/1.1 201 Created");
                   //echo json_encode($jsonList); //返回给客户端token信息
                   $data = array(
                        'access_token'=>JWT::encode($access_token,C('TOKEN_KEY')),
                        'refresh_token'=>JWT::encode($refresh_token,C('TOKEN_KEY')),
                        'token_type'=>'bearer', //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
                        'info' => '登录成功',
                        'res' =>200
                   );
	        }
    	}else{
            $data = array(
                    'info' => '请输入用户名和密码',
                    'res' =>103
            );
        }

        $this->ajaxReturn($data);
    }
    //通过token获取用户信息
    public function getuinfo(){
        $headers=getallheaders();
        $httpAuthorization = $headers['Authorization'];
        $arr = explode(" ",$httpAuthorization);
        $jwt = $arr[1];  //$arr[0]为Bearer

        if(!empty($arr) && !empty($jwt)){
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($jwt, C('TOKEN_KEY'), ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            if(!empty($arr['type'])){ //如果验证未通过
                print_r($arr['msg']);
            }else{
                $res['userid'] = $arr['data']->userid;
                $res['username'] = $arr['data']->username;
                $this->ajaxReturn($res);
            }
        }
    }

    //通过reftoken刷新token
    public function reftoken(){
        $headers=getallheaders();
        $httpAuthorization = $headers['Authorization'];
        $arr = explode(" ",$httpAuthorization);
        $refjwt = $arr[1];

        if(!empty($arr) && !empty($refjwt)){
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($refjwt, C('TOKEN_KEY'), ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            if(!empty($arr['type'])){ //如果验证未通过
                print_r($arr['msg']);
            }else{
                $uid = $arr['data']->userid;
                $uname = $arr['data']->username;
                //再次生成token
                $t = time();
                 $token = array(
                    "iss" => "bms",
                    "aud" => "api.beimsn.com",

                    "iat" => $t,
                    'nbf' => $t,
                    'data' => [ 
                        'userid' => $uid,
                        'username' => $uname
                    ]
                 );
                 $access_token = $token;
                 $access_token['scopes'] = 'role_access'; //token标识，请求接口的token
                 $access_token['exp'] = $t+C('TOKEN_TIME');

                 Header("HTTP/1.1 201 Created");
                 //echo json_encode($jsonList); //返回给客户端token信息
                 $data = array(
                      'access_token'=>JWT::encode($access_token,C('TOKEN_KEY')),
                      'refresh_token'=>$refjwt,
                      'token_type'=>'bearer', //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
                      'info' => '刷新token成功',
                      'res' =>200
                 );
                 $this->ajaxReturn($data);

            }
        }
    }

    public function reg(){
    	if(IS_POST){
            $userModel = D('user');
            if(!$userModel->create()){
                $this->ajaxReturn($userModel->getError());
                exit;
            }
            //$userModel->passwd = md5($userModel->passwd.$s);
            //$userModel->salt = $s;
            $regs = $userModel->add();
            if($regs){
               $data = array(
                    'info' => '注册成功',
                    'res' =>201
               );
            }else{
               $data = array(
                    'info' => '注册失败',
                    'res' =>301
               );
            }
        }else{
            $data = array(
                    'info' => '请输入用户名和密码',
                    'res' =>103
            );
        }
        $this->ajaxReturn($data);
    }
    public function jm($a){
       return md5($a); 
    }
}