<?php
namespace Home\Controller;
use Think\Controller;
// use Home\Model\MenuModel;
class MenuController extends Controller{
    private $menuModel;
    
    public function __construct(){
        parent::__construct();
        $this->menuModel = M("menu");
    }
    
    public function loadTableMenu(){
        $page = $this->menuModel->select();
        $this->ajaxReturn($page);
        
    }
    public function menuManage(){
        $this->display();
    }
    public function load12Menu(){
        $menu12 = $this->menuModel->load12Menu();
        $this->ajaxReturn($menu12);
    }
    public function saveOrUpdateMenu($name, $url, $parentid, $isshow, $menuid){
        if ($menuid == ""){
            $result = $this->menuModel->saveMenu($name, $url, $parentid, $isshow,0);
            $this->ajaxReturn("insertOK","eval");
        }else {
            $result = $this->menuModel->UpdateMenu($name, $url, $parentid, $isshow, $menuid);
            $this->ajaxReturn("updateOK","eval");
        }
    }
    public function loadMenuById($menuid){
        $menus = $this->menuModel->loadMenuById($menuid);
        $this->ajaxReturn($menus);
    }
    public function deleteMenu($menuids){
        $menu = $this->menuModel->deleteMenu($menuids);
        $this->ajaxReturn($menu);
    }
    
    
}

?>