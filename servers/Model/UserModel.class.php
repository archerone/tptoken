<?php  
namespace Model;
use Think\Model;

class UserModel extends Model{
	//实现表单验证
	//通过重写$_validate实现验证
	protected $_validate        =   array(
        
        //验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        //验证用户名,require必须填写项目
        array('uname','require','用户名必须填写'),
        array('uname','8,18','名称长度不符合','1','length','3'),
        array('upasswd','require','密码必须填写'),
        array('upasswd','8,18','密码格式不对','1','length','3'),
//        //可以为同一个项目设置多个验证
        array('upasswd2','require','确认密码必须填写'),
//        //与密码的值得是一致的
        array('upasswd2','password','与密码的信息必须一致',0,'confirm'),
        //邮箱验证
        array('uemail','email','邮箱格式不正确',2),
    ); 
}