<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;
use Home\entity\Menu;
class ClassController extends Controller{
    private $classModel;
    
//     static  $connection = array(
//         'DB_TYPE'               =>  'mysql',     // 数据库类型
//         'DB_HOST'               =>  'localhost', // 服务器地址
//         'DB_NAME'               =>  'sys',          // 数据库名
//         'DB_USER'               =>  'root',      // 用户名
//         'DB_PWD'                =>  '921129',          // 密码
//         'DB_PORT'               =>  3306,        // 端口
//         'DB_PREFIX'             =>  '',    // 数据库表前缀
//         'DB_PARAMS'          	=>  array(
//             \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION
//         )
//     );
    
    public function __construct(){
        parent::__construct();
        //$this->classModel = M("class","",C("DB_DSN"));//new Model("class");
        //$this->classModel = new  Model("class","",self::$connection);
        //$this->classModel = M("class");
        $this->classModel = M("class");
    }
    
    
    public function classManage(){
        $this->display();
    }
    public function loadClassByPage($pageNo=1,$pageSize=10,$className=null,$headerName=null,$managerName=null,$createtime1=null,$createtime2=null,$begintime1=null,$begintime2=null,$endtime1=null,$endtime2=null,$status=-1){
        $sql=" from class c,tb_user u1,tb_user u2 where c.headerid=u1.uid and c.managerid=u2.uid ";
        if (null != $className){
            $sql .=" and c.name like '%$className%'";
        }
        if(null != $createtime1){
            $sql.=" and c.createTime >= '".$createtime1."'";
        }
        if(null != $createtime2){
            $sql.=" and c.createTime <= '".$createtime2."'";
        }
        
        if (null != $headerName){
            $sql .=" and u1.trueName like '%$headerName%'";
        }
        if(null != $begintime1){
            $sql.=" and c.beginTime >= '".$begintime1."'";
        }
        if(null != $begintime2){
            $sql.=" and c.beginTime <= '".$begintime2."'";
        }
        
        if (null != $managerName){
            $sql .=" and u2.trueName like '%$managerName%'";
        }
        if(null != $endtime1){
            $sql.=" and c.endTime >= '".$endtime1."'";
        }
        if(null != $endtime2){
            $sql.=" and c.endTime <= '".$endtime2."'";
        }
        
        if (-1 != $status){
            $sql .=" and c.status = '".$status."'";
        }
        
        
        //$count = $this->classModel->table("class c,tb_user t,tb_user tt")->field("count(*) as cc")->where("t.uid=c.headerid and tt.uid=c.managerid")->find()["cc"];
        $count = $this->classModel->query("select count(*) as cc ".$sql)[0]["cc"];
        $page["total"] = $count;
        
        //$rows = $this->classModel->table("class c,tb_user t,tb_user tt")->field("c.cid,c.name,t.trueName aa,tt.trueName bb,c.classType,c.createTime,c.beginTime,c.endTime,c.status")->where("t.uid=c.headerid and tt.uid=c.managerid")->page($pageNo,$pageSize)->select();
        $begin = ($pageNo-1)*$pageSize;
        $rows = $this->classModel->query("select c.cid,c.name,c.classtype,c.status,c.createtime,c.begintime,c.endtime,u1.trueName as headername,u2.trueName as managename,c.stucount,c.remark".$sql."limit $begin,$pageSize");
        $page["rows" ]= $rows;
        $this->ajaxReturn($page);
    }
    
    /**
     * 检查所选班级今天是否有考试
     * @param unknown $cids 参数绑定格式为1,2,3...
     */
    public function checkExamToday($cids=null){
        $d = date("Y-m-d");
        $db = $d." 00:00:00";
        $de = $d." 23:59:59";
        $data = $this->classModel->table("exam")->where("classid in ($cids) and beginTime between '$db' and '$de'")->select();
//         print_r($data);
        if(count($data)>0){
            $classids = array();
            foreach ($data as $exam){
                array_push($classids, $exam["classid"]);
            }
            $str = implode(",", $classids);
            //查询今天有考试的班级名称
            $cnames = $this->classModel->field("name")->where("cid in ($str)")->select();
            //存放今天有考试的班级名称的数组
            $names = array();
            foreach ($cnames as $n){
                array_push($names, $n["name"]);
            }
//             echo "对不起，".implode(",", $names)."今天有考试，不能合并";
            $this->ajaxReturn("对不起，".implode(",", $names)."今天有考试，不能合并","EVAL");
            
        }else{
            $this->ajaxReturn("OK","EVAL");
        }
        //$sql="select * from exam where classid in ($cids) and beginTime between $db and $de";
    }
    
    public function managerid(){
        $data = array(array("uid"=>"-1","truename"=>"指定合并后项目经理名字"));
        $row = $this->classModel->table("tb_user")->field("uid,trueName")->where("userType=3")->select();
        foreach ($row as $r){
            array_push($data, $r);
        }
        echo json_encode($data);
    }
    public function headerid(){
        $data = array(array("uid"=>"-1","truename"=>"指定合并后班主任名字"));
        $row = $this->classModel->table("tb_user")->field("uid,trueName")->where("userType=2")->select();
        foreach ($row as $r){
            array_push($data, $r);
        }
        echo json_encode($data);
    }
    
    public function hebingClass($cids=null,$classid=-1,$combinedmanagerid=-1,$combinedheaderid=-1){
        try {
            $this->classModel->setProperty(\PDO::ATTR_AUTOCOMMIT, false);
            $this->classModel->startTrans();//开始事务
            $classes = $this->classModel->table("class")->where("cid in ($cids)")->select();
            $totalcount = 0;
            foreach ($classes as $c){
                if($c["cid"] == $classid){
                    //要保留的班级
                }else{
                    $totalcount += $c["stucount"];
                    $c["stucount"] = 0;
                    $c["status"]=2;
                    $this->classModel->save($c);
                    $sql = "update tb_user set classid =%d where classid = %d";
                    $this->classModel->execute($sql,$classid,$c["cids"]);
                }
            }
            $combinedclass = $this->classModel->table("class")->where("cid =%d",$classid)->find();
            $combinedclass["headerid"] = $combinedheaderid;
            $combinedclass["managerid"] = $combinedmanagerid;
            $combinedclass["stucount"] += $totalcount;
            $this->classModel->save($combinedclass);
            $this->classModel->commit();
            
        } catch (\Exception $e) {
            $this->classModel->rollback();
        }
        $this->loadClassByPage();
    }
    
    
    
    
    
    
    
    
    
    
    public function LoadAllClasses(){
//         $data = $this->classModel->select();
        $data = $this->classModel->select();
        $arrayLength = count($data);
        $this->assign("arrayLength",$arrayLength);
        $this->assign("data",$data);
        $this->assign("j",5);
        $this->assign("msg","<b style='color:red'>没有数据!</b>");
//         print_r($data);
        $this->assign("aa","哈哈哈");
        $this->assign("str","abcde");
        $this->display();//查找默认的模板进行展示
        //$this->display("index","utf-8","text/html");//查找另一个模板进行展示
        //$this->display("User/user");//跨文件夹查找模板展示
    }
    
    
    
    
}

?>