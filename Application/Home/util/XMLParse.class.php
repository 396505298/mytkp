<?php
/**
 * XML解析的工具类
 * @author j
 * @return 数据库的dsn 用户名 密码组成的数组
 */
namespace Home\util;

class XMLParse{
    public static function parseDBXML(){
        //初始化
        $sx = simplexml_load_file(dirname(__DIR__)."/config/db.xml");
        //获取某个节点下所有子节点 返回数组
        $children = $sx->children();
        //取出
        $pdoMysql = array((string)$children[0]->dsn,(string)$children[0]->username,(string)$children[0]->userpass);
        
        return $pdoMysql;
    }
    
}

?>