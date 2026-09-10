<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Block.php';
	
	$category_sql = "select * from e_poster_category where del='N' and depth='1' order by sort_num asc";
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
		if($sort_field=='poster_number'){
			$sort_sql = "order by CAST(SUBSTR(poster_number,3,2) AS UNSIGNED) $orderby, CAST(SUBSTRING_INDEX(poster_number, '-', -1) AS UNSIGNED) ".$orderby;
		}else{
			$sort_sql .= " order by ".$sort_field;
		}
	}
	if(!$orderby){
		$sort_sql .= " desc";
	}else{
		if($sort_field!='poster_number'){
		$sort_sql .= " ".$orderby;
		}
	}

	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','msid','num_page');

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
				}else if($tkey=="category"){
					$search_query[] = " $tkey = '".$tval."' ";
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

	$query = "select count(*) from e_poster" .$fsql;
	$totalRecord=$conn->getOne($query);
	
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();

	$query = "select * from e_poster" .$fsql;
	$query .= $sort_sql;
	$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
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

?>
<script>
	function reset_views(){
		if(confirm("View카운트를 초기화하시겠습니까?")){
			location.href="view_reset.php"
		}
	}
</script>
<div class="tp10 bp10">
<form name="searchF" id="searchF" method="post" action="<?=$PHP_SELF?>">
<table class="tblDef">
	<colgroup>
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
			<td class="al" ><input type="text" name="subject" id="subject" value="<?=$subject?>" style="width:85%;"></td>
		</tr>
		<tr>
			<th>Presenter</th>
			<td class="al"><input type="text" name="presenter" id="presenter" value="<?=$presenter?>" style="width:85%;"></td>
			<th>Presenter Affiliation</th>
			<td class="al"><input type="text" name="presenter_aff" id="presenter_aff" value="<?=$presenter_aff?>" style="width:85%;"></td>
			<th>Code</th>
			<td class="al" ><input type="text" name="code" id="code" value="<?=$code?>" style="width:85%;"></td>
		</tr>
	</tbody>
</table>
<div class="ac tp10">
	<span class="rBtnAdmin medium navy"><button type="submit" onclick="location.href='<?=$PHP_SELF?>'">검색</button></span>
	<span class="rBtnAdmin medium gray"><button type="button" onclick="location.href='<?=$PHP_SELF?>'">초기화</button></span>
	<span class="rBtnAdmin medium green"><button type="button" onclick="location.href='excel_backup.php'">Excel Backup</button></span>
</div>
</form>
</div>
<div class="bp5">
	<div style="float:left;">
		<span class="btnAdmin medium black <?if($category){?>empty<?}?>"><button type="button" onclick="location.href='<?=$PHP_SELF?>'">전체</button></span>
		<?if($category_sid){?>
			<?foreach($category_sid as $tkey=>$tval){?>
			<span class="btnAdmin medium black <?if($category!=$category_sid[$tkey]){?>empty<?}?>"><button type="button" onclick="location.href='<?=$PHP_SELF?>?category=<?=$category_sid[$tkey]?>'"><?=$category_title[$tkey]?></button></span>
			<?}?>
		<?}?>
	</div>
	<div style="float:right;">
		<span class="btnAdmin medium green"><button type="button" onclick="reset_views()">View 초기화</button></span>
		<span class="btnAdmin medium green"><button type="button" onclick="popup_call('excel/upload','kind=poster')">Excel Upload</button></span>
		<span class="btnAdmin medium darkPink"><button type="button" onclick="popup_call('e_poster/file_upload','')">Poster Upload(Image)</button></span>
		<span class="btnAdmin medium darkPink"><button type="button" onclick="popup_call('e_poster/file_upload_ppt','')">Poster Upload(pptx)</button></span>
	</div>
</div>
<br />
<table class="tblDef ">
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 8%;">
		<col style="width: 12%;">
		<col style="width: 7%;">
		<!-- <col style="width: 7%;"> -->
		<col style="">
		<col style="width: 6%;">
		<col style="width: 10%;">
		<!-- <col style="width: 10%;"> -->
		<col style="width: 4%;">
		<col style="width: 4%;">
		<col style="width: 4%;">
		<col style="width: 4%;">
		<col style="width: 6%;">
		<col style="width: 3%;">
		<col style="width: 4%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>Category</th>
			<th>Sub Category</th>
			<th><?=admin_orderby("Poster No.","poster_number",$sort_field,$orderby,$search_url)?></th>
			<!-- <th>ID</th> -->
			<th><?=admin_orderby("Subject","subject",$sort_field,$orderby,$search_url)?></th>
			<th><?=admin_orderby("Presenter","presenter",$sort_field,$orderby,$search_url)?></th>
			<th>소속</th>
			<!-- <th>공저자</th> -->
			<!-- <th>소속</th> -->
			<th>댓글</th>
			<th>Like</th>
			<th>Favor</th>
			<th>View</th>
			<th>포스터</th>
			<th>철회</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
		<?
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

				$file_cnt = $conn->getOne("select* from e_poster_file where psid='".$d['sid']."'");
				$comment_cnt = $conn->getOne("select count(*) from comment_tbl where replace(number,'s_','')='".$d['sid']."'");

				$star_score = $conn->getOne("select sum(score) from e_poster_star_tbl where psid='".$d['sid']."'");
				$vchk = $conn->getOne("select count(*) from e_poster_view_tbl where  psid='".$d['sid']."'");
		?>
		<tr>
			<td><?=$virtualRecordNo?></td>
			<td><?=$conn->getOne("select title from e_poster_category where sid='".$d['category']."' and depth='1' and del='N'")?></td>
			<td><?=$conn->getOne("select title from e_poster_category where sid='".$d['category_sub']."' and depth='2' and del='N'")?></td>
			<td><?=$d['poster_number']?></td>
			<!-- <td><?=$d['id']?></td> -->
			<td class="al"><?=nl2br($d['subject'])?></td>
			<td><?=stripslashes($d['presenter'])?></td>
			<td><?=stripslashes($d['presenter_aff'])?></td>
			<!-- <td><?=stripslashes($d['co_author'])?></td> -->
			<!-- <td><?=stripslashes($d['position'])?></td> -->
			<td>
				<span class="btnAdmin small lightBlue <?if($comment_cnt==0){?>empty<?}?>" ><button type="button" onclick="popup_call('e_poster/comment_list','sid=<?=$d['sid']?>')">보기(<?=$comment_cnt?>)</button></span>
			</td>
			<td><?=$conn->getOne("select count(*) from e_poster_like where psid='".$d['sid']."'")?></td>
			<td><?=$conn->getOne("select count(*) from e_poster_favor where psid='".$d['sid']."'")?></td>
			<td>
			<?if($vchk>0){?><div style="font-size:9px;"><?=$vchk?></div><?}?>
			</td>
			<td>
				<!-- <?
					if($d['e_poster_file']){
						if(file_exists($_SERVER['DOCUMENT_ROOT'].'upload/e_poster/'.$d['e_poster_file'])){
							echo IconType2($d['e_poster_file']);
						}
					}
				?> -->
				<?if($file_cnt>0){?>
				<div class="bp5"><span class="btnAdmin small navy" style="height:20px;"><button type="button" onclick="popup_call('e_poster/poster_file','sid=<?=$d['sid']?>')">File</button></span><img src="/image/icon/icon_del.png" onclick="common_delete('<?=$d['sid']?>','e_poster_file')" valign="middle"></div>
				<?}?>
				<span class="btnAdmin small green" style="width:58px;"><button type="button" onclick="popup_call('e_poster/file_upload','sid=<?=$d['sid']?>')">Upload</button></span>
			</td>
			
			<td><input type="checkbox" style="width:25px;height:25px;margin:0px;padding:0px;" key="<?=$d['sid']?>" kind="poster_withdraw" class="check_value" <?if($d['withdraw']=='Y'){?>checked<?}?>></td>
			<td>
				<img src="/image/icon/icon_modify.png" onclick="popup_call('poster/postform','sid=<?=$d['sid']?>')">
				<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$d['sid']?>','e_poster')">
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
<div class="btnArea posRel tp0">
	<?include $_SERVER['DOCUMENT_ROOT']."/include.page.php"?>						
</div>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>