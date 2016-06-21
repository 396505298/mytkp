<?php
//应用配置/全局配置
return array(
	//'配置项'=>'配置值'
	
    //数据库PDO配置
// 	"DSN"=>"mysql:host=localhost:3306;dbname=sys",
//     "DBUSER"=>"root",
//     "DBPASS"=>"921129",
//     "DBPORT"=>3306,
    
//     "PDOOPTIONS"=>array(
//         \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION
//     ),
    
    //修改默认的模板目录结构为 控制器类名称_操作方法名
    //'TMPL_FILE_DEPR'=>'_',
    //数据库连接的字符串格式
    //"DB_DSN" =>"mysql://root:921129@localhost:3306/sys#utf8",
    
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'sys',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '921129',          // 密码
    'DB_PORT'               =>  3306,        // 端口
    'DB_PREFIX'             =>  '',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(
        \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION
    ), // 数据库连接参数
    
    //分页查询配置
    "PAGENO"=>1,
    "PAGESIZE"=>10,
    //设置URL模式为REWRITE模式
//     'URL_MODEL'=>2
    //Action配置按顺序绑定
//     'URL_PARAMS_BIND_TYPE' => 1
    //开启路由
    'URL_ROUTER_ON'=>true,
    'URL_ROUTE_RULES'=>array(
        'ttt/:name/:pwd'    =>  "Home/Index/index",
        'login'             =>  "Home/User/login",
        'aaa/:year/:month/:date'=>"Home/Index/aa"
    )
    
    
);