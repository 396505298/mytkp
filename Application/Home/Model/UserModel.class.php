<?php
namespace Home\Model;

use Home\util\DButil;
class UserModel{
    private $dbUtil;
    
    public function __construct(){
        $this->dbUtil =  new DButil();
    }
    
    /**
     * 登錄驗證
     * @param unknown $userName
     * @param unknown $userPass
     * @return 1表示登錄成功   2表示用戶不存在  3表示密碼錯
     */
    public function login($userName,$userPass){
        $sql = "select * from tb_user where userName=?";
        $datas= $this->dbUtil->executeQuery($sql,array($userName));
        if (count($datas) > 0){
            //用戶存在
            if ($userPass == $datas[0][2]){
                //用戶名密碼正確
                return 1;
            }else {
                //密碼錯誤
                return 3;
            }
        }else{
            //用戶名不存在
            return 2;
        }
    }
    
    /**
     * 通过用户名加载用户数据数组
     * @param unknown $userName
     * @return 查询成功就返回该用户的整行数据组成的数组 否则返回null
     */
    public function loadUserByName($userName){
        $sql = "select * from tb_user where userName=?";
        $datas= $this->dbUtil->executeQuery($sql,array($userName));
        if (count($datas) == 1){
            return $datas[0];
        }else{
            return null;
        }
    }
    
    public function loadTableUser($pageNo,$pageSize){
        $sql = "select t.uid,t.userName,t.userPass,t.userType,t.trueName,t.sex,t.phone,t.school,t.status,t.birthDay from tb_user t limit ?,?";
        $sql2 = "select count(*) from tb_user";
        //
        $pageData = $this->dbUtil->executePageSubQuery($sql, $sql2, $pageNo, $pageSize,array(),\PDO::FETCH_OBJ,'Home\entity\User');
    
        return $pageData;
    
    }
    
    
    public function saveUser($userName,$userPass,$userType,$trueName,$sex,$phone,$school,$status,$birthDay){
        $sql = "insert into tb_user(userName,userPass,userType,trueName,sex,phone,school,status,birthDay) values(?,?,?,?,?,?,?,?,?)";
        if ($this->dbUtil->executeDML($sql,array($userName,$userPass,$userType,$trueName,$sex,$phone,$school,$status,$birthDay))){
            return "insertOK";
        }else {
            return "NO";
        }
    }
    
    public function updateUser($userName,$userPass,$userType,$trueName,$sex,$phone,$school,$status,$birthDay,$uid){
        $sql = "update tb_user set userName=?,userPass=?,userType=?,trueName=?,sex=?,phone=?,school=?,status=?,birthDay=? where uid=?";
        if ($this->dbUtil->executeDML($sql,array($userName,$userPass,$userType,$trueName,$sex,$phone,$school,$status,$birthDay,$uid))){
            return "updateOK";
        }else {
            return "NO";
        }
    }
    
    public function loadUserById($uid){
    
        $sql = "select * from tb_user where uid=?";
        $e = $this->dbUtil->executeQuery($sql,array($uid),\PDO::FETCH_OBJ,'entity\User');
        return $e[0];
    
    }
    public function deleteUser($uid){
        $sql = "delete from tb_user where uid in ($uid)";
        $a = $this->dbUtil->executeDML($sql);
        return $a;
    }
}

?>