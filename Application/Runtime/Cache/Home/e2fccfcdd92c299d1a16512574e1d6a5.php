<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
	</head>
	<body>
		模板<br/>
		<?php echo ($aa); ?><br/>
		<?php echo ($_SERVER['HTTP_USER_AGENT']); ?><br/>
		<?php echo (md5($str)); ?><br/> 
		<?php echo (substr($str,0,3)); ?><br/>
		<?php echo ((isset($str) && ($str !== ""))?($str):"问号"); ?><br/>
		<?php echo ($data["0"]["cid"]); ?><br/>
		<table border="1" bordercolor="blue" cellspacing="0" width="1200px">
			<tr>
				<td>编号</td>
				<td>名字</td>
				<td>类型</td>
				<td>状态</td>
				<td>创建时间</td>
				<td>开班时间</td>
				<td>结束时间</td>
				<td>班主任</td>
				<td>项目经理</td>
				<td>人数</td>
				<td>备注</td>
			</tr>
			
			<!--<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "$msg" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?>第<?php echo ($i); ?>次循环-索引为<?php echo ($key); ?>
				<?php if(($mod) == "0"): ?><tr style="background-color: green;">
						<td><?php echo ($c["cid"]); ?></td>
						<td><?php echo ($c["name"]); ?></td>
						<td><?php echo ($c["classtype"]); ?></td>
						<td><?php echo ($c["status"]); ?></td>
						<td><?php echo ($c["createtime"]); ?></td>
						<td><?php echo ($c["begintime"]); ?></td>
						<td><?php echo ($c["endtime"]); ?></td>
						<td><?php echo ($c["headerid"]); ?></td>
						<td><?php echo ($c["managerid"]); ?></td>
						<td><?php echo ($c["stucount"]); ?></td>
						<td><?php echo ($c["remark"]); ?></td>
					</tr><?php endif; ?>
				<?php if(($mod) == "1"): ?><tr style="background-color: gray;">
						<td><?php echo ($c["cid"]); ?></td>
						<td><?php echo ($c["name"]); ?></td>
						<td><?php echo ($c["classtype"]); ?></td>
						<td><?php echo ($c["status"]); ?></td>
						<td><?php echo ($c["createtime"]); ?></td>
						<td><?php echo ($c["begintime"]); ?></td>
						<td><?php echo ($c["endtime"]); ?></td>
						<td><?php echo ($c["headerid"]); ?></td>
						<td><?php echo ($c["managerid"]); ?></td>
						<td><?php echo ($c["stucount"]); ?></td>
						<td><?php echo ($c["remark"]); ?></td>
					</tr><?php endif; endforeach; endif; else: echo "$msg" ;endif; ?>-->
			
			
			
			<!-- <?php $__FOR_START_25702__=$arrayLength-1;$__FOR_END_25702__=0;for($i=$__FOR_START_25702__;$i >= $__FOR_END_25702__;$i+=-1){ ?>-->
			<!--  <for start="0" end="$arrayLength" step="1" name="i" >
			<?php if(($i%2) == "0"): ?><tr style="background-color: green;">
						<td><?php echo ($data["$i"]["cid"]); ?></td>
						<td><?php echo ($data["$i"]["name"]); ?></td>
						<td><?php echo ($data["$i"]["classtype"]); ?></td>
						<td><?php echo ($data["$i"]["status"]); ?></td>
						<td><?php echo ($data["$i"]["createtime"]); ?></td>
						<td><?php echo ($data["$i"]["begintime"]); ?></td>
						<td><?php echo ($data["$i"]["endtime"]); ?></td>
						<td><?php echo ($data["$i"]["headerid"]); ?></td>
						<td><?php echo ($data["$i"]["managerid"]); ?></td>
						<td><?php echo ($data["$i"]["stucount"]); ?></td>
						<td><?php echo ($data["$i"]["remark"]); ?></td>
					</tr><?php endif; ?>
				<?php if(($i%2) == "1"): ?><tr style="background-color: gray;">
						<td><?php echo ($data["$i"]["cid"]); ?></td>
						<td><?php echo ($data["$i"]["name"]); ?></td>
						<td><?php echo ($data["$i"]["classtype"]); ?></td>
						<td><?php echo ($data["$i"]["status"]); ?></td>
						<td><?php echo ($data["$i"]["createtime"]); ?></td>
						<td><?php echo ($data["$i"]["begintime"]); ?></td>
						<td><?php echo ($data["$i"]["endtime"]); ?></td>
						<td><?php echo ($data["$i"]["headerid"]); ?></td>
						<td><?php echo ($data["$i"]["managerid"]); ?></td>
						<td><?php echo ($data["$i"]["stucount"]); ?></td>
						<td><?php echo ($data["$i"]["remark"]); ?></td>
					</tr><?php endif; } ?>-->
			
			
			<?php if(is_array($data)): foreach($data as $i=>$c): if(($i%2) == "0"): ?><tr style="background-color: green;">
						<td><?php echo ($c["cid"]); ?></td>
						<td><?php echo ($c["name"]); ?></td>
						<td>
							<?php if($c["classtype"] == 1): ?>常规班
							<?php elseif($c["classtype"] == 2): ?>快速班
							<?php elseif($c["classtype"] == 3): ?>FALSH班
							<?php else: ?>PHP班<?php endif; ?>
						</td>
						<td>
							<?php if($c["status"] == 1): ?>正常
							<?php elseif($c["status"] == 2): ?>被合并
							<?php elseif($c["status"] == 3): ?>结业
							<?php else: ?>已废除<?php endif; ?>
						</td>
						<td><?php echo ($c["createtime"]); ?></td>
						<td><?php echo ($c["begintime"]); ?></td>
						<td><?php echo ($c["endtime"]); ?></td>
						<td><?php echo ($c["headerid"]); ?></td>
						<td><?php echo ($c["managerid"]); ?></td>
						<td><?php echo ($c["stucount"]); ?></td>
						<td><?php echo ($c["remark"]); ?></td>
					</tr><?php endif; ?>
				<?php if(($i%2) == "1"): ?><tr style="background-color: gray;">
						<td><?php echo ($c["cid"]); ?></td>
						<td><?php echo ($c["name"]); ?></td>
						<td>
							<?php if($c["classtype"] == 1): ?>常规班
							<?php elseif($c["classtype"] == 2): ?>快速班
							<?php elseif($c["classtype"] == 3): ?>FALSH班
							<?php else: ?>PHP班<?php endif; ?>
						</td>
						<td>
							<?php if($c["status"] == 1): ?>正常
							<?php elseif($c["status"] == 2): ?>被合并
							<?php elseif($c["status"] == 3): ?>结业
							<?php else: ?>已废除<?php endif; ?>
						</td>
						<td><?php echo ($c["createtime"]); ?></td>
						<td><?php echo ($c["begintime"]); ?></td>
						<td><?php echo ($c["endtime"]); ?></td>
						<td><?php echo ($c["headerid"]); ?></td>
						<td><?php echo ($c["managerid"]); ?></td>
						<td><?php echo ($c["stucount"]); ?></td>
						<td><?php echo ($c["remark"]); ?></td>
					</tr><?php endif; endforeach; endif; ?>
		</table>
		<?php if($j == 4): ?>哈哈
		<?php elseif($j == 5): ?>
			恩恩
		<?php else: ?>
			呵呵<?php endif; ?>
	</body>
</html>