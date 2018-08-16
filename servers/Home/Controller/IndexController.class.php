<?php
namespace Home\Controller;
use Component\TokenController;
class IndexController extends TokenController {
    public function banner(){
       header('Content-type: application/json'); 
       $banner = new \Model\BannerModel();
       $binfo = $banner->where(array('fpage'=>'home'))->select();

       $this->ajaxReturn($binfo);
    }
}