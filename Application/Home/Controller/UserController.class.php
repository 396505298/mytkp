<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\UserModel;
use Home\Model\MenuModel;
class UserController extends Controller{
    
    private $userModel;
    private $menuModel;
    
    public function __construct(){
        parent::__construct();
        $this->userModel = new UserModel();
        $this->menuModel = new MenuModel();
    }
    
    public function login(){
        $userName = $_POST["userName"];
        $userPass = $_POST["userPass"];
        $i = $this->userModel->login($userName,$userPass);
        if ($i ==1){
            //登录成功 加载当前用户对象
            $user = $this->userModel->loadUserByName($userName);
            $_SESSION["loginUser"] = $user;
            //取出当前登录用户的主键ID，用来查询他拥有的菜单
            $uid = $_SESSION["loginUser"][0];
            $secondMenu = $this->menuModel->loadTreeMenu($uid);
            $_SESSION["secondMenu"] = $secondMenu;
            
            header("location:http://localhost:8080/mytkp/welcome.php");
        }elseif($i ==2){
            //用户名不存在
            $_SESSION["loginError"] = "用户不存在";
            header("location:../index.php");
        }else {
            //密码错误
            $_SESSION["loginError"] = "密码错误";
            header("location:../index.php");
        }
        
    }
    
    public function loadUser($pageNo=1,$pageSize=10){
        $pageData = $this->userModel->loadTableUser($pageNo, $pageSize);
        $this->ajaxReturn($pageData);
    }
    
    
    
}

?>