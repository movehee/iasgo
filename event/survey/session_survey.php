<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Block.php';
	
	
	$lec_query = "select t1.sid,t1.title,t1.author,t1.detail_time,t2.ev_date from workshop_session_detail_tbl as t1 inner join workshop_session_tbl as t2 on t1.session_sid=t2.sid ";
	$lec_query .= " where t1.title not like '%패널%' and t1.title not like '%폐회%' order by t2.sort_num asc, t1.sort_num asc";

	
	$lec_result=$conn->query($lec_query);
	if(DB::isError($lec_result)) die($lec_result->getMessage());
	$n=1;
	while ($l = $lec_result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$ex_author = explode("(",$l['author']);
		if($l['ev_date']=='1'){
			$lec_arr1[] = $ex_author[0];
		}else{
			$lec_arr2[] = $ex_author[0];
		}
	}
	



	/*여기서 부터 검색관련부분임*/
	if(!$search_type) $search_type = "and";
	
	$sort_sql ="";
	if(!$sort_field){
		$sort_sql .= " order by t1.sid";
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
			$fsql = " where (".implode($search_type,$search_query) . ") and t1.usid>0";
		}else{
			$fsql = " where ".implode($search_type,$search_query) . " and t1.usid>0";
		}
	}else{
		$fsql = " where t1.usid>0";
	}

	/*여기까지가 검색관련부분임*/

	$query = "select count(*) from session_survey_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid" .$fsql;
	$totalRecord=$conn->getOne($query);
	
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();

	$query = "select t1.*,t2.name_kr,t2.license_number,t2.reg_kind,t2.gubun1 from session_survey_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid" .$fsql;
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
<div class="btn bp5" style="float:right;">
<a href="session_survey_excel.php" class="btnGreen2 withIcon"><i class="fas fa-download" style="font-size:15px;padding-top:0px;"></i>Excel Backup</a>
</div>

<table class="tblDef ">
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<?foreach($lec_arr1 as $tkey=>$tval){?>
		<col style="width: 5%;">
		<?}?>
		<col style="width: 5%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>구분</th>
			<th>성명</th>
			<th>면허번호</th>
			<th>직종</th>
			<th>감염관리<br>담당자</th>
			<th>감염관리<br>경력</th>
			<th colspan=12>평가</th>
			<th>의견</th>
		</tr>
	</thead>
	<tbody>
		<?
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
		<tr>
			<td rowspan=4><?=$virtualRecordNo?></td>
			<td rowspan=4>
				<?if($d['reg_kind']){?><div><?=$_REG['reg_kind'][$d['reg_kind']]?></div><?}?>
				<?if($d['gubun1']){?><div><?=$_REG['gubun1'][$d['gubun1']]?></div><?}?>
			</td>
			<td rowspan=4><?=$d['name_kr']?></td>
			<td rowspan=4><?=$d['license_number']?></td>

			<td rowspan=4><?=$_SURVEY['job'][$d['job']]?></td>
			<td rowspan=4><?=$_SURVEY['charge'][$d['charge']]?></td>
			<td rowspan=4><?=$d['yearv']?></td>
			<?foreach($lec_arr1 as $tkey=>$tval){?>
			<th><?=$tval?></th>
			<?}?>
			<td rowspan=4><?=nl2br($d['memo'])?></td>
		</tr>
		<tr>
			<?foreach($lec_arr1 as $tkey=>$tval){?>
			<td><?=$_SURVEY['answer'][$d['answer1_'.($tkey+1)]]?></td>
			<?}?>
		</tr>
		<tr>
			<?foreach($lec_arr2 as $tkey=>$tval){?>
			<th><?=$tval?></th>
			<?}?>
		</tr>
		<tr>
			<?foreach($lec_arr2 as $tkey=>$tval){?>
			<td><?=$_SURVEY['answer'][$d['answer2_'.($tkey+1)]]?></td>
			<?}?>
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