<?php
namespace Home\Model;

use Home\util\DButil;
/**
 * 专注于访问menu表
 * @author j
 *
 */
class MenuModel{
    private $dbUtil;
    
    public function __construct(){
        $this->dbUtil =  new DButil();
    }
    
    /**
     * 首页左侧属性菜单加载数据
     * @return 所有
     */
    public function loadTreeMenu($uid){
        $menu2 = array();
        $m2s = array();
        $sql = "select m.* from userrole ur,rolemenu rm,menu m where ur.rid=rm.rid and rm.menuid=m.menuid and m.isshow=1 and ur.uid=? and m.parentid=?";
        //查询一级菜单 只有一个
        $menus = $this->dbUtil->executeQuery($sql,array($uid,-1));
        $menu1 = $menus[0];
        //查询二级菜单，通过一级菜单主键ID区查询
        $menu2 = $this->dbUtil->executeQuery($sql,array($uid,$menu1[0]));
        //循环每一个二级菜单，通过每一个二级菜单的主键ID去查询他下面的子菜单
        foreach ($menu2 as $second){
            $m2 = array();
            array_push($m2, $second[0],$second[1],$second[2],$second[3],$second[4]);
            $menu3 = $this->dbUtil->executeQuery($sql,array($uid,$second[0]));
//          $second->setChildren($menu3);
            array_push($m2, $menu3);
            array_push($m2s, $m2);
        }
        return $m2s;
    }
    
    
    
    
    
    public function loadTableMenu($pageNo,$pageSize){
        $begin = ($pageNo-1)*$pageSize;
        $sql = "select m.menuid,m.name,m.url,(select m2.name from menu m2 where m2.menuid=m.parentid) as parentName,m.isshow from menu m limit $begin,$pageSize";
        $sql2 = "select count(*) from menu";
        //
        $pageData = $this->dbUtil->executePageSubQuery($sql, $sql2, $pageNo, $pageSize,array(),\PDO::FETCH_ASSOC);
        
        return $pageData;
        
    }
    
    
    public function load12Menu(){
        $sql = "select * from menu where parentid=?";
        //存放数组
        $fsmenu = array();
        $menus = $this->dbUtil->executeQuery($sql,array(-1),\PDO::FETCH_OBJ,'Home\entity\Menu');
        $menu1 = $menus[0];
        $menu1->setName("一级->".$menu1->getName());
        //一级菜单放入数组
        array_push($fsmenu, $menu1);
        $menu2 = $this->dbUtil->executeQuery($sql,array($menu1->getMenuid()),\PDO::FETCH_OBJ,'Home\entity\Menu');
        foreach ($menu2 as $second){
            $second->setName("二级->".$second->getName());
            array_push($fsmenu, $second);
        }
        
        return $fsmenu;
        
    }
    
    public function saveMenu($name,$url,$parentid,$isshow){
        $sql = "insert into menu(name,url,parentid,isshow) values(?,?,?,?)";
        if ($this->dbUtil->executeDML($sql,array($name,$url,$parentid,$isshow))){
            return "insertOK";
        }else {
            return "NO";
        }
    }
        
    public function updateMenu($name,$url,$parentid,$isshow,$menuid){
        $sql = "update menu set name=?,url=?,parentid=?,isshow=? where menuid=?";
        if ($this->dbUtil->executeDML($sql,array($name,$url,$parentid,$isshow,$menuid))){
            return "updateOK";
        }else {
            return "NO";
        }
    }  
    
    
    
    public function loadMenuById($menuid){
        
            $sql = "select * from menu where menuid=?";
            $e = $this->dbUtil->executeQuery($sql,array($menuid),\PDO::FETCH_OBJ,'Home\entity\Menu');
            return $e[0];
        
    }
    
    
    
    public function deleteMenu($menuids){
        
        $sql = "delete from menu where menuid in ($menuids)";
        $this->dbUtil->executeDML($sql);
        
   }
        
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>