<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
?>
<script>
	function reset_session(fsid,dsid){
		if(confirm("선택하신 세션을 삭제하시겠습니까?")){
			$.ajax({
				type:"POST",
				url:"/popup/program/session_select_faculty_reg.php",
				data:"fsid="+fsid+"&dsid="+dsid+"&type=T",
				async:false,
				success:function(msg){
					if(msg=='Y'){
						//parent.$('.session_title_area_'+fsid+'_'+dsid).load("/load/faculty_session_load.php?sid="+dsid);
						//parent.$.colorbox.close();
						location.reload();
					}
				}
			});
		}
	}
</script>
<link rel="stylesheet" href="/script/pickout/dev/pickout.css">
<link rel="stylesheet" href="/script/pickout/dev/themes/pk-cricket.css">
<style>
.pk-modal{padding:0; margin:0;width:30%;}
.pk-form{width:500px;}
.pk-search{display:none !important;}
.main{padding:0;margin:0;}
.pk-field{width:100%;padding:3px;margin:0px;color:#FFFF00 !important}
.pk-arrow{display:none;}

td.iconMove {}
td.iconMove:before {display: inline-block;font-size: 30px;font-family: "Font Awesome 5 Free" !important;font-weight: 900;content: "\f0b2";}
</style>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script>
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
					url:"/faculty/sort_change.php",
					data:"sort_val="+join_sort+"&kind=faculty",
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
	});

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
<link rel="stylesheet" href="/script/fancybox/jquery.fancybox.min.css" />
<script src="/script/fancybox/jquery.fancybox.min.js"></script>
<div style="clear:both;"></div>

<?
	$search_sql = "";
	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code','ev_date','unsel','room','faculty_photo','faculty_cv','faculty_abs');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				$search_query[] = " $tkey like '%".$tval."%' ";
			}
		}
	}
	if($faculty_photo=='Y') $search_query[] = " (faculty_photo!='' and faculty_photo is not null)";
	if($faculty_cv=='Y') $search_query[] = " (faculty_cv!='' and faculty_cv is not null)";
	if($faculty_abs=='Y') $search_query[] = " (faculty_abs!='' and faculty_abs is not null)";


	if($search_query){
		$fsql = " where ".implode(" and ",$search_query) . " and sid is not null";
	}else{
		$fsql = " where sid is not null";
	}

	$query = "select * from faculty_tbl" .$fsql;
	$query .= " order by sort_num asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<div>
	<div class="btn bp5" style="float:left;">
		<a href="faculty.php" class="btnSky withIcon"><i class="fa fa-backward" style="font-size:15px;padding-top:0px;"></i>리스트로 돌아가기</a>
	</div>
</div>
<table class="tblDef sort_table">
	<colgroup>
		<col style="width: 5%;">
		<col style="width: 7%;">
		<col style="">
		<col style="width:200px;">
		<col style="width:200px;">
		<col style="width:150px;">
		<col style="width:65px;">
		<col style="width:70px;">
	</colgroup>
	<thead>
		<tr>
			<th style="background:#263238;color:#ffffff;">Sort</i></th>
			<th style="background:#263238;color:#ffffff;">사진</i></th>
			<th style="background:#263238;color:#ffffff;">Name</th>
			<th style="background:#263238;color:#ffffff;">Affiliation</th>
			<th style="background:#263238;color:#ffffff;">E-mail</th>
			<th style="background:#263238;color:#ffffff;">Country</th>
			<th style="background:#263238;color:#ffffff;">Flag</th>
			
			<th style="background:#263238;color:#ffffff;">관리</th>
		</tr>
	</thead>
	<tbody id="product">
		<?
			$ev_num = 0;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				if(file_exists($_SERVER['DOCUMENT_ROOT'].'upload/faculty/thumb/'.$d['faculty_photo'])){
					$fac_image = '/upload/faculty/thumb/'.$d['faculty_photo'];
				}else{
					$fac_image = '/upload/faculty/'.$d['faculty_photo'];
				}
				$Resize_img = imgResize($fac_image,75,75);
		?>
		<tr id="<?=$d['sid']?>" >
			<th style="background:#445964;color:#ffffff;margin:0px;font-size:30px;"><span class="numberic"></span></th>
			<th style="background:#445964;color:#ffffff;margin:0px;padding:5px;" >
				<?if($d['faculty_photo']){?>
					<a id="fancyimg" href="/upload/faculty/<?=$d['faculty_photo']?>" data-fancybox="gallery"><?=$Resize_img?></a>
				<?}else{?>
					<i class="far fa-id-card" style="font-size:60px;"></i>
				<?}?>
			</td>
			<th style="background:#445964;color:#ffffff;" class="al">
				<?=$d['faculty_name']?>
			</th>
			<th style="background:#445964;color:#ffffff;" class="al">
				<?=$d['faculty_aff']?>
			</th>
			<th style="background:#445964;color:#ffffff;" class="al">
				<?=$d['faculty_email']?>
			</th>
			<th style="background:#445964;color:#ffffff;" class="ac">
				<?=$d['faculty_country']?>
			</th>
			<th style="background:#445964;color:#ffffff;"><?if($_Flag['country'][$d['faculty_country']]){?><img src="/upload/flag/thumb/<?=$_Flag['country'][$d['faculty_country']]?>.png" ><?}?></th>
			
			<td class="ac iconMove">
				<input type="hidden" name="que_number[]" class="que_number" value="<?=$i?>" style="width:20px;">
			</td>
		</tr>
		<?}?>
	</tbody>
</table>
<script src="/script/pickout.js"></script>
<script>
	// With Search
	pickout.to({
		el:'.pickout, .pickout_category, .pickout_category_sub',
		search: true,
		theme: 'cricket',
		txtBtnMultiple: 'CONFIRMAR SELECIONADAS'
	});
	pickout.updated('.fkind .fcategory_sub .fcategory_sub');
</script>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>