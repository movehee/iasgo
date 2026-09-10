<?include "./../header.php";?>


<?

$num_per_page2 = 5;
$num_per_page = 20;
if(empty($page)) $page = 0;
$query="SELECT * FROM regist_tbl where code='".$code."' and del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM regist_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);


$totalRecord = $row['cnt'];

$query.=" order by sid desc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, $query);



$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);



$name_query="SELECT * FROM regist_set_tbl where sid='".$setting_col['reg_name']."'";
$name_result = mysqli_query($conn, $name_query);
$name_col = mysqli_fetch_array($name_result);


$office_query="SELECT * FROM regist_set_tbl where sid='".$setting_col['reg_office']."'";
$office_result = mysqli_query($conn, $office_query);
$office_col = mysqli_fetch_array($office_result);


$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");


$cnt = $totalRecord - $page*$num_per_page;
?>
<div id="container" style="width: 1700px;">
	
		<h2 class="tooltipPoint" title="*셋팅 순서*  1)접수내역관리에서 접수하는 데이터 등록 (상황에 따라 Type도 등록) 2) 사전등록 Excel파일은 개발자가 일괄 등록 3) Setting 작업 4)개발자가 Print 페이지 제작(./print/code.php) code는 해당 행사 코드값">등록 관리</h2>
		 
		<div class="contents member">

			<p class="btn" style="top: -44px; right: 530px; position: absolute;"><a onclick="javascript:print2('<?=$code?>')" class="btnDef"><i class="fas fa-eye"></i>프린트</a></p>

			<p class="btn" style="top: -44px; right: 400px; position: absolute;"><a onclick="javascript:statistics('<?=$code?>')" class="btnDef"><i class="fas fa-eye"></i>통계보기</a></p>

			<p class="btn" style="top: -44px; right: 280px; position: absolute;"><a href="" onclick="javascript:set('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>Setting</a></p>
		
			<p class="btn" style="top: -44px; right: 118px; position: absolute;"><a href="" onclick="javascript:set2('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>접수내역관리</a></p>

			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a href="" onclick="javascript:add('<?=$code?>')" class="btnDef">등록</a></p>
			
		 	<div class="registTotal">총 등록자 수 : <span class="registNum"><?=$totalRecord?></span>명</div> 
			<table class="tblList">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th><?=$name_col['info']?></th>
						<th><?=$office_col['info']?></th>
		
						<?
						while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
							<th><?=$tab_col['name']?> 입실</th>
							<th><?=$tab_col['name']?> 퇴실</th>
						<?}
						mysqli_data_seek($tab_result,0); 
						?>
						<th width="10%">관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
					<tr class="bg" id="<?=$d['sid']?>">

						<td  width="5%"><?=$cnt?></td>

						<td><?=$d['info'.$name_col['orderby']]?></td>
						<td><?=$d['info'.$office_col['orderby']]?></td>

						<?
						while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
							<td><?if($d['check_in'.$tab_col['day']]){?><?=date("Y.m.d H시i분",$d['check_in'.$tab_col['day']])?><?}?></td>
							<td><?if($d['check_out'.$tab_col['day']]){?><?=date("Y.m.d H시i분",$d['check_out'.$tab_col['day']])?><?}?></td>
						<?}
						mysqli_data_seek($tab_result,0); 
						?>



						<td width="10%">
							<a onclick="javascript:print('<?=$code?>','<?=$d['sid']?>')"> <img src="/admin/image/btn_print.png" alt="출력" /></a>
							<a href="" onclick="javascript:modify('<?=$code?>','<?=$d['sid']?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
							<a href="" onclick="javascript:del('<?=$d['sid']?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
						</td>
					</tr>
				<?
					$cnt--;
						}?>
					
				</tbody>
			</table>

			<ul class="pager">

			<?
				$s = floor($page / $num_per_page2);
				$s = $s * $num_per_page2;
				$max = ceil($totalRecord / $num_per_page);
				if($max>$s+$num_per_page2){
					$e = $s+$num_per_page2;
				}else{
					$e = $max;
				}
			?>


			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=0<?if($search){?>&search=<?=$search?><?}?>"><i class="fas fa-angle-double-left"></i></a></li>
			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?if($page-$num_per_page2>0){ echo $page-3;}else{echo "0";}?><?if($search){?>&search=<?=$search?><?}?>"><i class="fas fa-angle-left"></i></a></li>
			<?

				for($i = $s; $i < $e ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?><?if($search){?>&search=<?=$search?><?}?>"><?=$i+1?></a></li>
				<?}
			?>

			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?if($page+$num_per_page2>$max-1){echo $max-1;}else{echo $page+$num_per_page2;}?><?if($search){?>&search=<?=$search?><?}?>"><i class="fas fa-angle-right"></i></a></li>
			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$max-1?><?if($search){?>&search=<?=$search?><?}?>"><i class="fas fa-angle-double-right"></i></a></li>
			</ul>
		</div>
		<!-- //contents -->
			
		
    
    </div> <!-- //container -->
	
<script type="text/javascript">

function print(code, sid) {
	window.open("./print/"+code+".php?code="+code+"&sid="+sid,"","width=1020,height=1404");
}

function all_chk(key) {

	obj = document.getElementsByName("chk_sid[]");
	var chk_val = "";
	for(i=0;i<obj.length;i++){
		obj[i].checked = key.checked;
		
	}

}

function print2(code) {
	
	
	obj = document.getElementsByName("chk_sid[]");
	var chk_val = "";
	for(i=0;i<obj.length;i++){
		if(obj[i].checked==true){
			//chk_val += obj[i].value+",";
			//alert(obj[i].value);

			//alert($("input[name='chk_sid[]']")[i].value);
			chk_val += ""+obj[i].value+",";

		}
	}
	window.open("./print/"+code+".php?code="+code+"&sid="+chk_val,"","width=1020,height=1404");

	//alert(chk_val);
	
	/*
	var fileValue = $("input[name='chk_sid']").length;
    var fileData = new Array(fileValue);
    for(var i=0; i<fileValue; i++){                        
		alert($("input[name='chk_sid']")[i].value);
         fileData[i] = $("input[name='chk_sid']")[i].value;
    }
	*/

}

function statistics(code) {
	window.open("statistics.php?code="+code,"","width=1230,height=950");
}

function set(code) {
	window.open("reg_set.php?code="+code,"","width=1230,height=950");
}

function set2(code) {
	window.open("set.php?code="+code,"");
}

function add(code) {
	window.open("add.php?code="+code,"","width=1230,height=950");
}

function modify(code, sid) {

	window.open("add.php?code="+code+"&sid="+sid,"","width=1230,height=950");
}	

function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"./del.php",
			data:"sid="+sid,
			success:function(msg){
				location.reload();
			}
		});
	}
}

</script>

   
<?include "./../footer.php";?>