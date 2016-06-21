<?php 
session_start();
$uid = $_SESSION["loginUser"][0];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>教学管理系统</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="Public/jquery-easyui-1.3.3/themes/default/easyui.css">
		<link type="text/css" rel="stylesheet" href="Public/jquery-easyui-1.3.3/themes/icon.css">
		<script type="text/javascript" src="Public/jquery-easyui-1.3.3/jquery.min.js"></script>
		<script type="text/javascript" src="Public/jquery-easyui-1.3.3/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="Public/jquery-easyui-1.3.3/locale/easyui-lang-zh_CN.js"></script>
		<script type="text/javascript">
		// 添加一个未选中状态的选项卡面板
		function addTabs(url,name){
			if($('#tabs').tabs("exists",name)){
				//如果当前面板已存在,就选中它
				$('#tabs').tabs("select",name);
			}else{
				// 添加一个未选中状态的选项卡面板
				$('#tabs').tabs('add',{
					title: name,
					selected: true,
					closable:true,
					content:"<iframe name='"+name+"' src='"+url+"' width=100% height=100% frameborder='0' scrolling='no'></iframe>"
				});
			}
		}
		</script>
	</head>
	<body class="easyui-layout">
        <div data-options="region:'north',split:true" style="height:100px;">
        	<div style="float: left;width: 200px; height: 80px;border: 1px solid black"></div>
        	<div style="float: right;width: 200px; height: 80px;border: 1px solid black">
			<?php 
        	   if (array_key_exists("loginUser", $_SESSION)){
        	       if ($_SESSION["loginUser"][3] ==3){
        	           echo "欢迎您,项目经理：" .$_SESSION["loginUser"][4];
        	       }elseif ($_SESSION["loginUser"][3] ==2){
        	           echo "欢迎您,班主任：" .$_SESSION["loginUser"][4];
        	       }elseif ($_SESSION["loginUser"][3] ==1){
        	           echo "欢迎您,校长：" .$_SESSION["loginUser"][4];
        	       }
        	       elseif ($_SESSION["loginUser"][3] ==4){
        	           echo "欢迎您,学员：" .$_SESSION["loginUser"][4];
        	       }
        	   }
        	?>
        	</div>
        </div>   
        <div data-options="region:'west',title:'菜单栏',split:true" style="width:200px;">
        	<ul id="tree" class="easyui-tree">  
			<?php 
			if(array_key_exists("secondMenu", $_SESSION)){
			    $secondMenu = $_SESSION["secondMenu"];
			    foreach ($secondMenu as $menu2){
			        echo "<li><span>{$menu2[1]}</span><ul>";
			        foreach ($menu2[5] as $menu3){
			            echo "<li><span><a href=\"javascript:addTabs('{$menu3[2]}','{$menu3[1]}');\">{$menu3[1]}</a></span></li>";
			        }
			        echo "</li></ul>";
			    }
			}
            	
        	?>
        	</ul>
        </div>
        
        
        
        <div data-options="region:'center'" style="padding:5px;background:#eee;">
            <div id="tabs" class="easyui-tabs" style="width:500px;height:250px;" data-options="fit:true">   
                <div title="欢迎" >   
                                       欢迎你    
                </div>   
            </div> 
   		</div>    
            
    </body>  


</html>


