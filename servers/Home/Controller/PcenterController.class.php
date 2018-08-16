<?php
namespace Home\Controller;
use Component\TokenController;
class PcenterController extends TokenController {
    public function index(){
    	if($username = session('username')){
         $data = array(
              'info' => $username
         );
    	}else{
         $data = array(
              'info' => '未登录',
              'res' =>302
         );
      }
      
      $this->ajaxReturn($data);
    }
}