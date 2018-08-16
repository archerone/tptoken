<?php
namespace Home\Controller;
use Component\TokenController;
class RecommendController extends TokenController {
	public function getre(){
       $ReModel = D('recommend');
	   $cpage = $_POST['cpage'];
	   $prev = 0;
	   if($cpage>1){
          $prev = $cpage-1;
	   }
	   $min = $prev*4;
	   $max = $cpage*4;
	   $Reinfo = $ReModel->where('id>'.$min.' AND id<='.$max)->select();
	   $this->ajaxReturn($Reinfo);
	}
}