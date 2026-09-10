<?
	include_once $_SERVER['DOCUMENT_ROOT'].'webinar/admin/include.header.php';
	
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

	$query = "select count(*) from brochure_tbl" .$fsql;
	$totalRecord=$conn->getOne($query);
	
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();

	$query = "select * from brochure_tbl" .$fsql;
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
<div>
	<div class="btn" style="float:right;">
		<a href="javascript:popup_call('brochure/postform','')" class="btnGrey withIcon"><i class="fas fa-edit"></i>Brochure 등록</a>
	</div>
</div>

<div style="clear:both;padding-bottom:5px;"></div>
<table class="tblDef">
	<colgroup>
		<col style="width: 5%;">
		<col style="width: 15%;">
		<col style="width: 20%;">
		<col style="">
		<col style="width: 5%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>Cover</th>
			<th>파일</th>
			<th>제목</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
		<?
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				if($d['brochure_file']){
					$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."webinar/upload/brochure/" . $d["brochure_file"]) . "&filename=" . base64_encode($d["brochure_realfile"]);
				}
		?>
		<tr>
			<td><?=$virtualRecordNo?></td>
			<td><img src="/<?=$_Path['link']?>/upload/brochure/<?=$d['cover_file']?>" style="width:100px;"></td>
			<td><a href="/webinar/func/download.php?<?=$queryString?>"><?=IconType2($d['brochure_file'])?></td>
			<td><?=$d['movie_title']?></td>
			<td>
				<img src="/<?=$_Path['link']?>/admin/image/icon_modify.png" onclick="popup_call('brochure/postform','mode=form&sid=<?=$d['sid']?>')">
				<img src="/<?=$_Path['link']?>/admin/image/icon_del.png" onclick="common_delete('<?=$d['sid']?>','brochure')">
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
	<?include $_SERVER['DOCUMENT_ROOT']."admin/include.page.php"?>						
</div>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'admin/include.footer.php';
?>