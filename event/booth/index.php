<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Block.php';
	
	$category_sql = "select * from booth_grade where del='N' order by sort_num asc";
	$category_result=$conn->query($category_sql);
	if(DB::isError($category_result)) die($category_result->getMessage());

	while(is_array($e=$category_result->fetchRow(DB_FETCHMODE_ASSOC))){
		if($e['sort_num']=='1'){
			$default_category = $e['sid'];
		}
		$category_sid[] = $e['sid'];
		$category_title[] = $e['title'];
	}
	

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
				}else if($tkey=="position"){
					$search_query[] = " (position_kr like '%".$tval."%' or position_en like '%".$tval."%') ";
				}else if($tkey=="booth_sid"){
					$search_query[] = " booth_sid='$tval'";
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

	

	$query = "select * from booth" .$fsql;
	$query .= " order by sort_num asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
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
					url:"/booth/sort_change_booth.php",
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
	});
	function master_login(id){
		if(confirm("해당 부스로 로그인 하시겠습니까?")){
			window.open("https://virtual.kcr4u.org/master_login.php?id="+id,"","widith=100%,height=1000,scrollbars=yes");
			//location.href="https://virtual.kcr4u.org/master_login.php?id="+id;
		}
	}

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
<!-- <div class="tp10 bp10">
<form name="searchF" id="searchF" method="post" action="<?=$PHP_SELF?>">
<table class="tblDef tblList">
	<colgroup>
		<col style="width: 10%;">
		<col style="width: 15%;">
		<col style="width: 10%;">
		<col style="width: 15%;">
		<col style="width: 10%;">
		<col style="width: 15%;">
		<col style="width: 10%;">
		<col style="width: 15%;">
	</colgroup>
	<tbody>
		<tr>
			<th>Category</th>
			<td class="al">
				<select name="category" id="category" style="height:33px;width:90%;">
					<option value="">선택</option>
					<?foreach($category_sid as $tkey=>$tval){?>
					<option value="<?=$category_sid[$tkey]?>" <?if($category==$category_sid[$tkey]){?>selected<?}?>><?=$category_title[$tkey]?></option>
					<?}?>
				</select>
			</td>
			<th>Poster No.</th>
			<td class="al"><input type="text" name="poster_number" id="poster_number" value="<?=$poster_number?>" style="width:85%;"></td>
			<th>Subject</th>
			<td class="al"><input type="text" name="subject" id="subject" value="<?=$subject?>" style="width:85%;"></td>
			<th>Author</th>
			<td class="al"><input type="text" name="author" id="author" value="<?=$author?>" style="width:85%;"></td>
		</tr>
	</tbody>
</table>
<div class="ac tp10">
	<span class="rBtnAdmin medium navy"><button type="submit" onclick="location.href='<?=$PHP_SELF?>'">검색</button></span>
	<span class="rBtnAdmin medium gray"><button type="button" onclick="location.href='<?=$PHP_SELF?>'">초기화</button></span>
</div>
</form>
</div> -->
<br>
<div class="bp5">
	<div style="float:left;">
		<span class="btnAdmin medium black <?if($booth_sid){?>empty<?}?>"><button type="button" onclick="location.href='<?=$PHP_SELF?>'">전체</button></span>
		<?if($category_sid){?>
			<?foreach($category_sid as $tkey=>$tval){?>
			<span class="btnAdmin medium black <?if($booth_sid!=$category_sid[$tkey]){?>empty<?}?>"><button type="button" onclick="location.href='<?=$PHP_SELF?>?booth_sid=<?=$category_sid[$tkey]?>'"><?=$category_title[$tkey]?></button></span>
			<?}?>
		<?}?>
	</div>
	<div style="float:right;">
		<span class="fcRed">부스 순서 변경은 카테고리를 선택 후 Drag하여 변경해주세요.</span>
		<span class="btnAdmin medium green"><button type="button" onclick="popup_call('excel/upload','kind=booth')">Excel Upload</button></span>

		<span class="btnAdmin medium green"><button type="button" onclick="location.href='stamp_excel.php'">Stamp Excel Dowm</button></span>
		<span class="btnAdmin medium green"><button type="button" onclick="location.href='stamp_event_excel.php'">Stamp Event Excel Dowm</button></span>
		<span class="btnAdmin medium green"><button type="button" onclick="location.href='book_excel.php'">Book Excel Dowm</button></span>

	</div>
</div>
<br />
<table class="tblDef <?if(!$booth_sid){?>sort_table<?}?>">
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 8%;">
		<col style="">
		<col style="width: 3%;">
		<col style="width: 3%;">
		<col style="width: 5%;">
		<col style="width: 4%;">
		<col style="width: 5%;">
		<col style="width: 4%;">
		<col style="width: 5%;">
		<col style="width: 4%;">
		<col style="width: 5%;">
		<col style="width: 8%;">
		<col style="width: 5%;">
		<col style="width: 4%;">
		<col style="width: 5%;">
		<col style="width: 4%;">
		<col style="width: 7%;">
		<col style="width: 4%;">
		<!-- <col style="width: 4%;"> -->
		<col style="width: 4%;">
	</colgroup>
	<thead>
		<tr>
			<th rowspan=2>No</th>
			<th rowspan=2>Category</th>
			<th rowspan=2>부스명</th>
			<th rowspan=2>Top</th>
			<th rowspan=2>이미지</th>
			<th colspan=2>Company</th>
			<th colspan=2>Brochures</th>
			<th colspan=2>Movie</th>
			<th colspan=2>Survey </th>
			<th colspan=2>Guest Book</th>
			<th colspan=2>Stamp Event</th>
			<th rowspan=2>Open</th>
			<!-- <th rowspan=2>Login</th> -->
			<th rowspan=2>View</th>
			<th rowspan=2>관리</th>
		</tr>
		<tr>
			<th colspan=2><input type="checkbox" class="chkall" key="op1" style="width:21px;height:21px;margin:0px;"> 전체 사용</th>
			<th colspan=2><input type="checkbox" class="chkall" key="op2" style="width:21px;height:21px;margin:0px;"> 전체 사용</th>
			<th colspan=2><input type="checkbox" class="chkall" key="op3" style="width:21px;height:21px;margin:0px;"> 전체 사용</th>
			<th colspan=2><input type="checkbox" class="chkall" key="op4" style="width:21px;height:21px;margin:0px;"> 전체 사용</th>
			<th colspan=2><input type="checkbox" class="chkall" key="op5" style="width:21px;height:21px;margin:0px;"> 전체 사용</th>
			<th colspan=2><input type="checkbox" class="chkall" key="op6" style="width:21px;height:21px;margin:0px;"> 전체 사용</th>
		</tr>
	</thead>
	<tbody id="product">
		<?
			$virtualRecordNo=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				unset($img_chk);
				if($d['logo_file'] || $d['booth_file'] || $d['front_file1'] || $d['front_file2'] || $d['front_file3'] || $d['front_file4']){
					$img_chk = "Y";
				}
				$op1_chk = $conn->getOne("select count(*) from booth_company where booth_sid='".$d['sid']."'");
				$op2_chk = $conn->getOne("select count(*) from booth_brochures where booth_sid='".$d['sid']."'");
				$op3_chk = $conn->getOne("select count(*) from booth_movie where booth_sid='".$d['sid']."'");
				$op4_chk = $conn->getOne("select count(*) from survey_tbl where booth_sid='".$d['sid']."'");

				$book_cnt = $conn->getOne("select count(*) from booth_book where booth_sid='".$d['sid']."'");

		?>
		<tr id="<?=$d['sid']?>">
			<td><span class="numberic"></span></td>
			<td><?=$conn->getOne("select title from booth_grade where sid='".$d['booth_sid']."' and del='N'")?></td>
			<td><?=$d['title']?></td>
			<td style="cursor:default;">
				<input type="checkbox" style="width:21px;height:21px;margin:0px;" name="top" id="top_<?=$d['sid']?>" class="check_ajax top" kind="top" value="<?=$d['sid']?>" <?if($d['top']=='Y'){?>checked<?}?>> 
			</td>
			<td>
				<span class="btnAdmin small <?if($img_chk=='Y'){?>blue<?}else{?>gray<?}?>"><button type="button" onclick="popup_call('booth/booth_image','sid=<?=$d['sid']?>')">등록</button></span>
			</td>

			<td style="cursor:default;">
				<input type="checkbox" style="width:21px;height:21px;margin:0px;" name="op1" id="op1_<?=$d['sid']?>" class="check_ajax op1" kind="op1" value="<?=$d['sid']?>" <?if($d['op1']=='Y'){?>checked<?}?>> <label for="op1_<?=$d['sid']?>" class="hand">사용</label>
			</td>
			<td style="cursor:default;">
				<span class="btnAdmin small <?if($op1_chk>0){?>blue<?}else{?>gray<?}?>" id="op1_<?=$d['sid']?>_btn" style="display:<?if($d['op1']!='Y'){?>none<?}?>;"><button type="button" onclick="popup_call('booth/company','sid=<?=$d['sid']?>')">등록</button></span>
			</td>

			<td style="cursor:default;">
				<input type="checkbox" style="width:21px;height:21px;margin:0px;" name="op2" id="op2_<?=$d['sid']?>" class="check_ajax op2" kind="op2" value="<?=$d['sid']?>" <?if($d['op2']=='Y'){?>checked<?}?>> <label for="op2_<?=$d['sid']?>" class="hand">사용</label>
			</td>
			<td style="cursor:default;">
				<span class="btnAdmin small <?if($op2_chk>0){?>blue<?}else{?>gray<?}?>" id="op2_<?=$d['sid']?>_btn" style="display:<?if($d['op2']!='Y'){?>none<?}?>;"><button type="button" onclick="popup_call('booth/brochures','sid=<?=$d['sid']?>')">등록</button></span>
			</td>

			<td style="cursor:default;">
				<input type="checkbox" style="width:21px;height:21px;margin:0px;" name="op3" id="op3_<?=$d['sid']?>" class="check_ajax op3" kind="op3" value="<?=$d['sid']?>" <?if($d['op3']=='Y'){?>checked<?}?>> <label for="op3_<?=$d['sid']?>" class="hand">사용</label>
			</td>
			<td style="cursor:default;">
				<span class="btnAdmin small <?if($op3_chk>0){?>blue<?}else{?>gray<?}?>" id="op3_<?=$d['sid']?>_btn" style="display:<?if($d['op3']!='Y'){?>none<?}?>;"><button type="button" onclick="popup_call('booth/movie','sid=<?=$d['sid']?>')">등록</button></span>
			</td>

			<td style="cursor:default;">
				<input type="checkbox" style="width:21px;height:21px;margin:0px;" name="op4" id="op4_<?=$d['sid']?>" class="check_ajax op4" kind="op4" value="<?=$d['sid']?>" <?if($d['op4']=='Y'){?>checked<?}?>> <label for="op4_<?=$d['sid']?>" class="hand">사용</label>
			</td>
			<td style="cursor:default;">
				
					<span class="btnAdmin small <?if($op4_chk>0){?>blue<?}else{?>gray<?}?>" id="op4_<?=$d['sid']?>_btn" style="display:<?if($d['op4']!='Y'){?>none<?}?>;"><button type="button" onclick="popup_call('booth/survey','sid=<?=$d['sid']?>')">등록</button></span>
				
				<?if($d['op4']=='Y'){?>
				<span class="btnAdmin small lightBlue" id="op5_<?=$d['sid']?>_btn" style="display:<?if($d['op4']!='Y'){?>none<?}?>;"><button type="button" onclick="popup_call('booth/survey_result','sid=<?=$d['sid']?>')">보기</button></span>
				<?}?>

			</td>

			<td style="cursor:default;">
				<input type="checkbox" style="width:21px;height:21px;margin:0px;" name="op5" id="op5_<?=$d['sid']?>" class="check_ajax op5" kind="op5" value="<?=$d['sid']?>" <?if($d['op5']=='Y'){?>checked<?}?>> <label for="op5_<?=$d['sid']?>" class="hand">사용</label>
			</td>
			<td style="cursor:default;">
				<span class="btnAdmin small lightBlue" id="op5_<?=$d['sid']?>_btn" style="display:<?if($d['op5']!='Y'){?>none<?}?>;"><button type="button" onclick="popup_call('booth/book','sid=<?=$d['sid']?>')">보기(<?=$book_cnt?>)</button></span>
			</td>

			<td style="cursor:default;">
				<input type="checkbox" style="width:21px;height:21px;margin:0px;" name="op6" id="op6_<?=$d['sid']?>" class="check_ajax op6" kind="op6" value="<?=$d['sid']?>" <?if($d['op6']=='Y'){?>checked<?}?>> <label for="op6_<?=$d['sid']?>" class="hand">사용</label>
			</td>
			<td style="cursor:default;">
				<span class="btnAdmin small lightBlue" id="op6_<?=$d['sid']?>_btn" style="display:<?if($d['op6']!='Y'){?>none<?}?>;"><button type="button" onclick="popup_call('booth/stamp','sid=<?=$d['sid']?>')">보기</button></span>
				<span class="btnAdmin small lightBlue" id="op6_<?=$d['sid']?>_btn" style="display:<?if($d['op6']!='Y'){?>none<?}?>;"><button type="button" onclick="popup_call('booth/qr','sid=<?=$d['sid']?>')">QR</button></span>
			</td>
			<td style="cursor:default;">
				<select name="open_type" onchange="booth_open_type(<?=$d['sid']?>,this.value)">
					<?foreach($_Booth['booth_open_type'] as $tkey=>$tval){?>
					<option value="<?=$tkey?>" <?if($d['open_type']==$tkey){?>selected<?}?>><?=$tval?></option>
					<?}?>
				</select>
			</td>
			<!-- <td style="cursor:default;">
				<?if($d['id']){?><i class="fas fa-person-booth" style="font-size:20px;cursor:pointer;" onclick="master_login('<?=$d['id']?>')"></i><?}?>
			</td> -->
			<td style="cursor:default;">
			<?
				echo $d['bcnt'];
				if($d['sid']=='9'){
					$Vcnt = $conn->getOne("select count(*) from booth_stamp where booth_sid='".$d['sid']."'");
				}else{
					$Vcnt = $conn->getOne("select count(sid) from booth_view_tbl where booth_sid='".$d['sid']."'");
				}
				//echo $Vcnt;
			?>
			</td>
			<td style="cursor:default;">
				<img src="/image/icon/icon_modify.png" onclick="popup_call('booth/postform','sid=<?=$d['sid']?>')">
				<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$d['sid']?>','booth')">
			</td>
		</tr>
		<?$virtualRecordNo++;}?>
	</tbody>
</table>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>