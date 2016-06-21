<?php
namespace Home\util;

/**
 * 封装增/删/改/查操作,为两个通用方法
 * @author j
 *
 */
class DButil{
    
    private $pdoMysql;
    
    private $pdo;
    
    public function __construct(){
//         $this->pdoMysql = XMLParse::parseDBXML();
//         $this->pdo = new \PDO($this->pdoMysql[0], $this->pdoMysql[1], $this->pdoMysql[2], array(\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION));
        //"DSN"=>"mysql:host=localhost:3306;dbname=sys",
         $this->pdo = new \PDO(C("DB_TYPE").":host=".C("DB_HOST").";dbname=".C("DB_NAME"), C("DB_USER"),C("DB_PWD") , C("DB_PARAMS"));
        //$this->pdo = new \PDO(C("DSN"), C("DBUSER"),C("DBPASS") , C("PDOOPTIONS"));
    }
    public function getPdo(){
        return $this->pdo;
    }
    
    /**
     * 通用的DML语句执行方法
     * @param unknown $sql 将要执行的DML语句,可以带有问号占位符
     * @param array $params 可选参数,当$sql有问号时,此参数必填;问号个数必须与此数组元素个数相同,若$sql中无?,此参数可不填,或添Null/array()
     * @return true表示成功 false失败
     */
    public function executeDML($sql,array $params=null){
        try {
            $ps = $this->pdo->prepare($sql);
            //参数数组补位空 并且元素个数大于0 需要绑定该参数
            if ($params != null && count($params) > 0){
                $ps->execute($params);
            }else {
                $ps->execute();
            }
            //关闭预处理对象
//             $ps->closeCursor();
            return true;
        } catch (\PDOException $e) {
            return false;
        }
        
    }
    
    
    /**
     * 通用的执行查询语句的方法
     * @param unknown $sql  执行查询语句,可以带有问号占位符
     * @param unknown $fetchStyle   可选参数,提取数据的方式,默认为提取为 \PDO::FETCH_NUM   可选值为PDO::FETCH_OBJ,assos
     * @param array $params 可选参数,当#sql有问号时,此参数必填;问号个数必须与此数组元素个数相同,若$sql中无?,此参数可不填,或添Null/array()
     * @param unknown $className    可选参数,当$fetchStyle取值为PDO::FETCH_OBJ时参数要求填写实体类的全名(命名空间/类名称)
     * @return array 当查询有数据则返回数据组成的数组,无数据时返回array()
     */
    public function executeQuery($sql,array $params=null,$fetchStyle=\PDO::FETCH_NUM,$className=null){
        try {
            $ps = $this->pdo->prepare($sql);
            //参数数组补位空 并且元素个数大于0 需要绑定该参数
            if ($params != null && count($params) > 0){
                $ps->execute($params);
            }else {
                $ps->execute();
            }
            if ($fetchStyle == \PDO::FETCH_OBJ){
                $objs = array();
                while ($obj = $ps->fetchObject($className)){
                    array_push($objs, $obj);
                }
                return $objs;
            }else {
                return $ps->fetchAll($fetchStyle);
            }
        } catch (\PDOException $e) {
            throw $e;
        }
        //如果方法执行抛异常,将返回一个空数组
        return array();
        
    }
    
    
    /**
     * 通用的执行查询语句的方法 并分页
     * @param unknown $sql
     * @param unknown $pageNo
     * @param unknown $pageSize
     * @param array $params
     * @param unknown $fetchStyle
     * @param unknown $className
     * @return 关联数组   有两个索引  索引total表示总共有多少行,索引rows表示当前页的数据数组
     */
    public function executePageQuery($sql,$pageNo,$pageSize,array $params=null,$fetchStyle=\PDO::FETCH_NUM,$className=null){
        //total rows
        $page = array();
        
        try {
            //chaxun 行数据
            $index1 = strpos($sql, "from");
            $index2 = strpos($sql, "limit");
            $sql2 = "select count(*) ".substr($sql,$index1,($index2-$index1));
            $ps2 = $this->pdo->prepare($sql2);
            $ps2->execute();
            $page["total"] = $ps2->fetch(\PDO::FETCH_NUM)[0];
            
            //参数数组补位空 并且元素个数大于0 需要绑定该参数
            $ps = $this->pdo->prepare($sql);
            $begin = ($pageNo-1)*$pageSize;
            $count = 0;
            str_replace("?", "?", $sql, $count);
            $ps->bindParam($count-1, $begin, \PDO::PARAM_INT);
            $ps->bindParam($count, $pageSize, \PDO::PARAM_INT);
            
            if ($params != null && count($params) > 0){
                $ps->execute($params);
            }else {
                $ps->execute();
            }
            if ($fetchStyle == \PDO::FETCH_OBJ){
                $objs = array();
                while ($obj = $ps->fetchObject($className)){
                    array_push($objs, $obj);
                }
                $page["rows"] = $objs;
            }else {
                $page["rows"] = $ps->fetchAll($fetchStyle);
            }
            
            
            
            
        } catch (\PDOException $e) {
            
        }
        return $page;
    }
    
    
    
    public function executePageSubQuery($datasql,$countsql2,$pageNo,$pageSize,array $params=null,$fetchStyle=\PDO::FETCH_NUM,$className=null){
        //total rows
        $page = array();
    
        try {
            //参数数组补位空 并且元素个数大于0 需要绑定该参数
            $ps = $this->pdo->prepare($datasql);
            $begin = ($pageNo-1)*$pageSize;
            $count = 0;
            str_replace("?", "?", $datasql, $count);
            if ($count>0) {
                $ps->bindParam($count-1, $begin, \PDO::PARAM_INT);
                $ps->bindParam($count, $pageSize, \PDO::PARAM_INT);
            }
            
            
            if ($params != null && count($params) > 0){
                $ps->execute($params);
            }else {
                $ps->execute();
            }
            if ($fetchStyle == \PDO::FETCH_OBJ){
                $objs = array();
                while ($obj = $ps->fetchObject($className)){
                    array_push($objs, $obj);
                }
                $page["rows"] = $objs;
            }else {
                $page["rows"] = $ps->fetchAll($fetchStyle);
            }
            
            
            //chaxun 行数据
//             $index1 = strpos($sql, "from");
//             $index2 = strpos($sql, "limit");
//             $sql2 = "select count(*) ".substr($sql,$index1,($index2-$index1));
            $ps2 = $this->pdo->prepare($countsql2);
            $ps2->execute();
            $page["total"] = $ps2->fetch(\PDO::FETCH_NUM)[0];
    
            
    
    
    
    
        } catch (\PDOException $e) {
    
        }
        return $page;
    }
    
    
    
    
    
    
    private function free($pdo,$ps){
        if ($pdo != null){
            $pdo = null;
        }
        if ($ps != null){
            $ps = null;
        }
    }
    
}

?>