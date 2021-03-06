<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="http://localhost:8080/mytkp/Public/jquery-easyui-1.3.3/themes/bootstrap/easyui.css">
		<link type="text/css" rel="stylesheet" href="http://localhost:8080/mytkp/Public/jquery-easyui-1.3.3/themes/icon.css">
		<script type="text/javascript" src="http://localhost:8080/mytkp/Public/jquery-easyui-1.3.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/mytkp/Public/jquery-easyui-1.3.3/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/mytkp/Public/jquery-easyui-1.3.3/locale/easyui-lang-zh_CN.js"></script>
		<style type="text/css">
        #fortable{
	        width: 60%;
	        margin:auto;
	        margin-top:20px;
        }
        #fortable tr{
            height:40px;	
        }
        </style>
		<script type="text/javascript">
		$(function(){
			$('#win').window('close');
			
			//创建的table
            $('#dg').datagrid({ 
    		    url:'http://localhost:8080/mytkp/index.php/Home/Class/loadClassByPage/pageNo/1/pageSize/10', 
    		    striped:true, 
    		    method:"GET",
    		    fitColumns:true, 
    		    pagination:true, 
    		    rownumbers:true,
    		    frozenColumns:[[
                    {field:'check',checkbox:true}
    		    ]],
    		    columns:[[    
    		        {field:'cid',hidden:true},    
    		        {field:'name',title:'班级名称',width:100,align:'center'},
    		        {field:'headername',title:'班主任',width:100,align:'center'},
    		        {field:'managename',title:'项目经理',width:100,align:'center'},    
    		        {field:'classtype',title:'班级类型',width:100,align:'center',formatter:function(value){
						if(value==1){
							return "常规班";
						}else if(value==2){
							return "速成班";
						}else if(value==3){
							return "flash班";
						}else if(value==4){
							return "php班";
						}
    		        }},
    		        {field:'createtime',title:'创建时间',width:100,align:'center',formatter:function(value){
						return value.substr(0,10);
        		    }},
    		        {field:'begintime',title:'开班时间',width:100,align:'center',formatter:function(value){
						return value.substr(0,10);
        		    }},
    		        {field:'endtime',title:'结业时间',width:100,align:'center',formatter:function(value){
						return value.substr(0,10);
        		    }},
    		        {field:'status',title:'状态',width:100,align:'center',formatter:function(value){
						if(value==1){
							return "正常";
						}else if(value==2){
							return "被合并";
						}else if(value==3){
							return "已结业";
						}else if(value==4){
							return "已废除";
						}
    		        }}
    		    ]],

    		    //table内的下拉列表/添加和删除按钮
    		    toolbar: "#tb"
    		    		        
    		}); 
    		
			//翻页功能/翻页工具
			var pager  = $("#dg").datagrid('getPager');
			
			pager.pagination({
				onSelectPage:function(pageNumber, pageSize){
					refreshData(pageNumber,pageSize);
				}
			});
		});

		//添加文件
		function saveOrUpdateClass(){
			var cid = $("#cid").val();
			var name = $("#name").val();
			var headerid = $("#headerid").val();
			var managerid = $("#managerid").val();
			var beginTime = $("#beginTime").combo('getValue');
			var classType = $("#classType").combo('getValue');
			var status = $("#status").combo('getValue');
			$.post('http://localhost:8080/mytkp/index.php/Home/Class/saveOrUpdateClass',{
				"cid"		: cid,
				"name"		: name,
				"headerid"	: headerid,
				"managerid"	: managerid,
				"beginTime" : beginTime,
				"classType"	: classType,
				"status"	: status
			},function(data){
				if(data=="insertOK"){
					$.messager.alert('消息','添加成功！','info',function(){
    					refreshData(1,10);
    					$('#win').window('close');
    					$('#ff').form('reset'); 
					});
				}else if(data=="updateOK"){
					$.messager.alert('消息','修改成功！','info',function(){
    					refreshData(1,10);
    					$('#win').window('close');
    					$('#ff').form('reset');
					});
				}
			},"text");
		}


		function refreshData(pageNumber,pageSize){
			$("#dg").datagrid('loading');
    //			alert('pageNumber:'+pageNumber+',pageSize:'+pageSize);
    		$.getJSON("http://localhost:8080/mytkp/index.php/Home/Class/loadClassByPage?pageNo="+pageNumber+"&pageSize="+pageSize,{},function(data){
    			$("#dg").datagrid('loadData',{
    				rows:data.rows,
    				total:data.total
    			});
    			var pager  = $("#dg").datagrid('getPager');
    			
    			pager.pagination({
    				pageSize:pageSize,
    				pageNumber:pageNumber
    			});
    			$("#dg").datagrid('loaded');
    		});
    		
		}
		function searchClass(){
			$.post("http://localhost:8080/mytkp/index.php/Home/Class/loadClassByPage",{
				'pageNo'		:1,
				'pageSize'		:10,
				'className'		:$("#className").val(),
				'createtime1'	:$("#createtime1").combo("getValue"),
				'createtime2'	:$("#createtime2").combo("getValue"),
				'headerName'	:$("#headerName").val(),
				'begintime1'	:$("#begintime1").combo("getValue"),
				'begintime2'	:$("#begintime2").combo("getValue"),
				'managerName'	:$("#managerName").val(),
				'endtime1'		:$("#endtime1").combo("getValue"),
				'endtime2'		:$("#endtime2").combo("getValue"),
				'status'		:$("#search-status").combo("getValue")
			},function(result){
				$("#dg").datagrid('loadData',{
    				rows:result.rows,
    				total:result.total
    			});
			},"json");
		}
		//班级合并
		/*
		至少选两个班级进行合并
		所选班级其中状态必须是正常的
		所选班级今天不能有考试
		*/
		function combineClass(){
			var selectedRows = $("#dg").datagrid("getSelections");
			if(selectedRows.length < 2){
				alert("至少选择两行进行合并");
				return;
			}
			var b = true;
			for(var i=0;i<selectedRows.length;i++){
				if(selectedRows[i].status != 1){
					b = false;
					break;
				}
			}
			if(!b){
				alert("所选班级状态必须全是正常");
				return;
			}
			//获取已选中的班的ID
			var cids = new Array();
			var options = new Array();
			options.push({"name":"合并后班级名称","cid":"-1"});
			for(var i=0;i<selectedRows.length;i++){
				cids.push(selectedRows[i].cid);
				options.push({"name":selectedRows[i].name,"cid":selectedRows[i].cid});
			}
			
			$.post("http://localhost:8080/mytkp/index.php/Home/Class/checkExamToday",{'cids':cids.join(",")},function(data){
				if(data == "OK"){
					$('#win').window('open');
					$("#classid").combobox({
						valueField:'cid',
						textField:'name',
						data:options,
						value:-1
					});
					$("#combinedmanagerid").combobox({
						url:"http://localhost:8080/mytkp/index.php/Home/Class/managerid",
						valueField:'uid',
						textField:'truename',
						value:-1
					});
					$("#combinedheaderid").combobox({
						url:"http://localhost:8080/mytkp/index.php/Home/Class/headerid",
						valueField:'uid',
						textField:'truename',
						value:-1
					});
				}else{
					alert(data);
				}
			},"text");
		}
		function hebingClass(){
			//获取已选中的班级的ID
			var cids = new Array();
			var selectedRows = $("#dg").datagrid("getSelections");
			for(var i=0;i<selectedRows.length;i++){
				cids.push(selectedRows[i].cid);
			}
			$.post("http://localhost:8080/mytkp/index.php/Home/Class/hebingClass",{
				"cids"				:cids.join(","),
				"classid"			:$("#classid").combo("getValue"),
				"combinedmanagerid" :$("#combinedmanagerid").combo("getValue"),
				"combinedheaderid"	:$("#combinedheaderid").combo("getValue")
			},function(result){
				$('#win').window('close');
				alert("班级合并成功！");
				$("#dg").datagrid('loadData',{
    				rows:result.rows,
    				total:result.total
    			});
			},"json")
		}
		</script>
	</head>
	<body>
		<table id="dg">
			
		</table>
		<div id="tb">
			<form action="" id="searchForm">
				<table>
					<tr>
        				<td><label>班级名称</label></td>
        				<td><input class="easyui-validatebox" type="text" id="className" name="className"  placeholder="请输入班级名称"/></td>
        				<td><label>创建时间</label></td>
        				<td><input class="easyui-datebox" type="text" id="createtime1" name="createtime1" data-options="editable:false"/></td>
        				<td>至</td>
        				<td><input class="easyui-datebox" type="text" id="createtime2" name="createtime2" data-options="editable:false"/></td>
        			</tr>
					<tr>
						<td><label>班主任</label></td>
						<td><input class="easyui-validatebox" type="text" id="headerName" name="headerName"  placeholder="请输入班主任姓名"/></td>
						<td><label>开班时间</label></td>
        				<td><input class="easyui-datebox" type="text" id="begintime1" name="begintime1" data-options="editable:false"/></td>
        				<td>至</td>
        				<td><input class="easyui-datebox" type="text" id="begintime2" name="begintime2" data-options="editable:false"/></td>
					</tr>
					<tr>
        				<td><label>项目经理</label></td>
        				<td><input class="easyui-validatebox" type="text" id="managerName" name="managerName" placeholder="请输入项目经理姓名"/></td>
        				<td><label>毕业时间</label></td>
        				<td><input class="easyui-datebox" type="text" id="endtime1" name="endtime1" data-options="editable:false"/></td>
        				<td>至</td>
        				<td><input class="easyui-datebox" type="text" id="endtime2" name="endtime2" data-options="editable:false"/></td>
        			</tr>
        			<tr>
        				<td><label>状态</label></td>
        				<td>
        					<select id="search-status" name="search-status" style="width:150px;" class="easyui-combobox">
        						<option value="-1">请选择状态</option>
        						<option value="1">正常</option>
        						<option value="2">被合并</option>
        						<option value="3">结业</option>
        						<option value="4">已废除</option>
        					</select>
        				</td>
        				<td>
        					<a href="javascript:searchClass();" class="easyui-linkbutton" data-options="iconCls:'icon-search'">搜索</a>
        					<a href="javascript:combineClass();" class="easyui-linkbutton" data-options="iconCls:'icon-collect',plain:true">合并</a>
        				</td>
        			</tr>
				</table>
			</form>
		</div>
		<div id="win" class="easyui-window" title="添加菜单" style="width:600px;height:400px"   
        	data-options="iconCls:'icon-collect',modal:true,collapsible:false,minimizable:false,maximizable:false,resizable:false">   
        	
        	<form id="ff" method="post"> 
        		<table id="fortable">
        			<tr>
        				<td align="right"><label for="classid">班级名字:</label></td>
        				<td>
        					<input class="easyui-combobox" type="text" id="classid" name="classid" data-options="editable:false"/>
        				</td>
        			</tr>
        			<tr>
        				<td align="right"><label for="combinedmanagerid">项目经理:</label></td>
        				<td>
        					<input class="easyui-combobox" type="text" id="combinedmanagerid" name="combinedmanagerid" data-options="editable:false"/>
        				</td>
        			</tr>
        			<tr>
        				<td align="right"><label for="combinedheaderid">班主任:</label></td>
        				<td>
        					<input class="easyui-combobox" type="text" id="combinedheaderid" name="combinedheaderid" data-options="editable:false"/>
    					</td>
        			</tr>
        			<tr>
        				<td align="center" colspan="2">
        					<a id="btn" href="javascript:hebingClass();" class="easyui-linkbutton" data-options="iconCls:'icon-submit'">提交</a>
        				</td>
        			</tr>
        		</table>  
            </form> 
        	        
        </div> 
		
	</body>
</html>