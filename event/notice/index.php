<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Block.php';
	


	/*여기서 부터 검색관련부분임*/
	if(!$search_type) $search_type = "and";
	
	$sort_sql ="";
	if(!$sort_field){
		$sort_sql .= " order by sid";
	}else{
		$sort_sql .= " order by ".$sort_field;
	}
	if(!$orderby){
		$sort_sql .= " desc";
	}else{
		$sort_sql .= " ".$orderby;
	}

	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','code','msid','num_page');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=="names"){
					$search_query[] = " (first_name like '%".$tval."%' or name_kr like '%".$tval."%' or last_name like '%".$tval."%') ";
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
			}
			$search_url .= "&$tkey=".$tval;
		}
	}
	if($li_page) $search_url .= "&li_page=".$li_page;


	if($search_query){
		if($search_type=="or"){
			$fsql = " where (".implode($search_type,$search_query) . ") and del='N'";
		}else{
			$fsql = " where ".implode($search_type,$search_query) . " and del='N'";
		}
	}else{
		$fsql = " where del='N'";
	}

	/*여기까지가 검색관련부분임*/

	$query = "select count(*) from w_notice_tbl" .$fsql;
	$totalRecord=$conn->getOne($query);
	
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();

	$query = "select * from w_notice_tbl" .$fsql;
	$query .= " order by sort_num asc";
	//$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	master_echo($query);

	$virtualRecordNo=$pageNav->getVirtualRecordNoInPage($totalRecord);
	
	# 블럭단위 계산
	$blockNav = new Block("", $totalPage, $page_per_block);
	$totalBlock = $blockNav->getTotalBlock();
	$blockNav->setBlock($page);
	$block = $blockNav->getBlock();
	$firstPageInBlock = $blockNav->getFirstPageInBlock();
	$lastPageInBlock = $blockNav->getLastPageInBlock();
	if($block >= $totalBlock) $lastPageInBlock = $totalPage;
	

	$room_cnt = $conn->getOne("select * from workshop_session_category where kind='P' and del='N'");
	if($room_cnt>0){
		$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
		$room_result=$conn->query($room_query);
		if(DB::isError($room_result)) die($room_result->getMessage());
		while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
			$room_sid[] = $r['sid'];
			$room_name[$r['sid']] = $r['title'];
		}
	}
	if($room_sid){
		$room_all_arr = implode(",",$room_sid);
	}
?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script>
$(document).ready(function(){
	$(".ajax").colorbox();
	$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
	$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
	$(".iframe").colorbox({iframe:true, width:"1345", height:"815"});
	$(".inline").colorbox({inline:true, width:"50%",height:'700'});
	$(".callbacks").colorbox({
		onOpen:function(){ alert('onOpen: colorbox is about to open'); },
		onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
		onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
		onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
		onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
	});
	

});
$(function(){
	$(".sort_table").tableDnD({ 
		//드래그 기능이 동작하는 동안 특정 CLASS를 드래그하는 TR에 적용해준다. 
		onDragStyle : 'dragRow2', 
		onDropStyle : 'dragRow2', 
		onDragClass: 'dragRow2',
		onDragStart: function(table, row){ 
			onDragClass: 'dragRow';
		},
		onDrop: function(table, row){ 
			var rows = table.tBodies[0].rows;
			var debugStr = "";
			var debugStr = new Array();
			for (var i=0; i<rows.length; i++) {
				//debugStr += rows[i].id + "||"; 
				debugStr[i] = rows[i].id; 
			}
			var join_sort = debugStr.join(",");
			
			$.ajax({
				type:"POST",
				url:"/notice/sort_change.php",
				data:"sort_val="+join_sort,
				cache:false,
				async:false,
				success:function(msg){
					if(msg=='Y'){
						alert("변경되었습니다.");
					}
				}
			});
		}
	});

	$('.room_all, .room_key').on('click',function(){
		var mykey = $(this).attr("key");
		if($(this).attr("class")=='room_all'){
			if($(this).is(':checked')==true){
				$('.room_sid'+mykey).prop('checked',true);
			}else{
				$('.room_sid'+mykey).prop('checked',false);
			}
		}
		var Keyarray=new Array();
		var total_cnt=0;
		$("input[name=room_sid"+mykey+"]").each(function(pi,po){
			if(po.checked==true){
				Keyarray[total_cnt] = po.value;
				total_cnt++;
			}
		});
		var keyjoin = Keyarray.join(",");
		
		$.ajax({
			type:"POST",
			url:"/notice/chking_room.php",
			data:"room_val="+keyjoin+"&sid="+mykey,
			cache:false,
			async:false,
			success:function(msg){
				
			}
		});
	});
})
</script>
<style>
	.dragRow{border:2px solid red !important;}
	.dragRow2{background:#f1ff44 !important;}
	.dragRow3{background:#FFA042 !important;}
	.dragRow_role{border:2px solid red !important;}
	.dragRow2_role{background:#EA6C55 !important;color:#ffffff;}
	

	#product {
		counter-reset: rowNumber;
	}
	.numberic:after {
		counter-increment: rowNumber;
		content: counter(rowNumber);
	}
</style>
<div>
	<div class="btn" style="float:right;">
		<a href="javascript:popup_call('notice/postform','')" class="btnGrey withIcon"><i class="fas fa-edit"></i>공지사항 등록</a>
	</div>
</div>
<div style="clear:both;padding-bottom:5px;"></div>
<table class="tblDef sort_table">
	<colgroup>
		<col style="width: 5%;">
		<col style="">
		<col style="width: 4%;">
		<col style="width: 4%;">
		<col style="width: 4%;">
		<?if(count($room_sid)>0){?><col style="width: 4%;"><?}?>
		<?foreach($room_sid as $tkey=>$tval){?>
		<col style="width: 6%;">
		<?}?>
		<col style="width: 5%;">
		<col style="width: 5%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>제목</th>
			<th>TOP</th>
			<th>노출여부</th>
			<th>PUSH</th>
			<?if(count($room_sid)>0){?>
			<th>전체</th>
			<?}?>
			<?foreach($room_sid as $tkey=>$tval){?>
			<th><?=$room_name[$tval]?></th>
			<?}?>
			<th>갱신</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody id="product">
		<?
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
		<tr id="<?=$d['sid']?>">
			<td><span class="numberic"></span></td>
			<td>
			<a class='inline' href="#inline_content<?=$d['sid']?>"><?=$d['subject']?></a>
			<div style='display:none'><div id="inline_content<?=$d['sid']?>"><?=$d['content']?></div></div>
			</td>
			<td><input type="checkbox" name="use_top" value="Y" class="use_top" <?if($d['top']=="Y"){?>checked<?}?> key="<?=$d['sid']?>" style="width:20px;height:20px;margin:0px;"></td></td>
			<td><input type="checkbox" name="use_yn" value="Y" class="use_yn" <?if($d['use_yn']=="Y"){?>checked<?}?> key="<?=$d['sid']?>" style="width:20px;height:20px;margin:0px;"></td></td>
			<td><input type="checkbox" name="push" value="Y" class="push" <?if($d['push']=="Y"){?>checked<?}?> key="<?=$d['sid']?>" kind="notice" style="width:20px;height:20px;margin:0px;"></td>
			<?if(count($room_sid)>0){?>
			<td><input type="checkbox" style="width:20px;height:20px;margin:0px;" <?if($room_all_arr==$d['room_sid']){?>checked<?}?> class="room_all" key="<?=$d['sid']?>"></td>
			<?}?>
			<?foreach($room_sid as $tkey=>$tval){?>
			<td><input type="checkbox" <?if(eregi($tval,$d['room_sid'])>0){?>checked<?}?> name="room_sid<?=$d['sid']?>" class="room_key room_sid<?=$d['sid']?>" key="<?=$d['sid']?>" value="<?=$tval?>" style="width:20px;height:20px;margin:0px;"></td>
			<?}?>
			<td style="cursor:default;"><span class="btnAdmin small blue"><button type="button" class="refresh_notice" key="<?=$d['sid']?>">갱신</button></span></td>
			
			<td style="cursor:default;">
				<img src="/image/icon_modify.png" onclick="popup_call('notice/postform','mode=form&sid=<?=$d['sid']?>')">
				<img src="/image/icon_del.png" onclick="common_delete('<?=$d['sid']?>','w_notice')">
			</td>
		</tr>
		<?$virtualRecordNo--;}?>
	</tbody>
</table>
<?
	if($add_search2) $search_url .= $add_search2;
	if($sort_field) $search_url .= "&sort_field=".$sort_field;
	if($orderby) $search_url .= "&orderby=".$orderby;
?>
<!-- <div class="btnArea posRel tp0">
	<?include $_SERVER['DOCUMENT_ROOT']."/include.page.php"?>						
</div> -->
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>