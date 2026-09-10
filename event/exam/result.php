<?include $_SERVER['DOCUMENT_ROOT']."include.header.php"?>
<?
	//include_once $_SERVER['DOCUMENT_ROOT'] . "func/config.exam.php";

	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';
	

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	
	if(!$ev_date) $ev_date = 1;

	


	$num_per_page = 50;
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = " order by exam_num asc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;
	
	if($_Activation['category']){
		if(!$category) $category="A";
	}
	

	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code','chkday','ev_date');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	if(!$kind) $kind="A";
	if(!$chkday) $chkday=1;	
	
	
	if(!$result_code) $result_code='1';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='s_sid'){
					$search_query[] = " society_sid = '".$tval."' ";
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
				
			}
			$search_url .= "&$tkey=".$tval;
		}
	}

	if($reg_gubun){
		$search_query[] = " FIND_IN_SET(reg_kind,'".implode(",",$reg_gubun)."')";
	}
	
	if($li_page) $search_url .= "&li_page=".$li_page;
	$search_url .= "&result_code=".$result_code;
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and day='$chkday'"; //and kind='$kind' and day='$chkday'
	}else{
		$fsql = " where del='N' and day='$chkday'"; //and kind='$kind' and day='$chkday'
	}
	if($_Activation['category']){
		$fsql .= " and category='$category'";
	}


	$exam_query = "select * from exam_tbl where del='N' and category='$category' and day='$chkday' order by exam_num asc";
	$exam_result=$conn->query($exam_query);
	if(DB::isError($exam_result)) die($exam_result->getMessage());
	
	while(is_array($e=$exam_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$exam_score_arr[] =  $e['score'];
		$exam_num_arr[] =  $e['exam_num'];
		$exam_ans_arr[] =  $e['answer'];
	}
	
	if(!$exam_num_arr){
		//PutMessageBack("등록된 문제가 없습니다.");
		//exit;
	}
	$query = "select a2.country,a2.name_kr,a2.name_eng, a2.license_number,a2.aff_kor,a2.aff_eng,a2.sid as usid,a2.etc_field2";
	if($exam_num_arr){
	foreach($exam_num_arr as $tkey=>$tval){
	$query .= ", group_concat(case when exam_num='".$tval."' then exam_pass else null end) exam_result".$tval;
	}
	}

	if($chkday>2) {
		$add_query = "a1.usid>0 and";
	}

	$query .= ", max(a1.signdate) as signdate"; 
	//$query .= "group_concat(case when exam_num='2' then exam_pass else null end) t2,";
	//$query .= "group_concat(case when exam_num='3' then exam_pass else null end) t3,";
	//$query .= "group_concat(case when exam_num='4' then exam_pass else null end) t4,";
	//$query .= "group_concat(case when exam_num='5' then exam_pass else null end) t5";
	$query .= " from exam_result_each_tbl as a1 left join registration_tbl as a2 on a1.usid=a2.sid where $add_query a1.day='$chkday' and a1.kind='$category' group by a1.usid";
	

	$cnt_query = "select count(*) from (".$query.") A";
	$totalRecord=$conn->getOne($cnt_query);
	
	
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();


	$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
	
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	

	$virtualRecordNo=$pageNav->getVirtualRecordNoInPage($totalRecord);
	
	# 블럭단위 계산
	$blockNav = new Block("", $totalPage, $page_per_block);
	$totalBlock = $blockNav->getTotalBlock();
	$blockNav->setBlock($page);
	$block = $blockNav->getBlock();
	$firstPageInBlock = $blockNav->getFirstPageInBlock();
	$lastPageInBlock = $blockNav->getLastPageInBlock();
	if($block >= $totalBlock) $lastPageInBlock = $totalPage;

	if($_Activation['category']){
		if(!$category) $category=key($_Exam['category']);
	}
	

	
?>
<div class="tp20"></div>


<div >
	<div class="btn" style="float:left;">
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&chkday=<?=$date?>" <?if($chkday==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
</div>

<div style="clear:both;padding-top:10px;">
	
	<?if($_Activation['category']){?>
	<div class="btn" style="float:left;">
		<?foreach($_Exam['category'] as $tkey=>$tval){?>
		<a href="<?=$PHP_SELF?>?category=<?=$tkey?>&chkday=<?=$chkday?>" <?if($category==$tkey){?>class="btnRed"<?}?>><?=$tval?></a></li>
		<?}?>
	</div>
	<?}?>
	<div class="btn" style="float:right;">
		<a href="result_excel.php?category=<?=$category?>&chkday=<?=$chkday?>" class="btnGreen"><i class="far fa-save" style="font-size:18px;padding-top:0px;"></i>Excel Download</a></li>
	</div>
	<!-- <div class="btn" style="float:right;margin-top:7px;">
		<a href="javascript:popup_call('exam/postform','kind=<?=$kind?>&chkday=<?=$chkday?>')" class="btnGrey withIcon"><i class="fas fa-edit"></i>문제 등록</a>
		<a -href="javascript:popup_call('excel/upload','kind=exam&chkkind=<?=$kind?>&chkday=<?=$chkday?>')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Excel Upload</a>
	</div> -->
</div>
<div style="clear:both;padding-bottom:10px;"></div>

<div class="contents tp10">
	<table class="tblDef">
		<colgroup>
			<col style="width: 4%;" />
			
			<col style="width: 6%;" />
			<col style="width: 6%;" />
			<col style="width: 10%;" />
			<?if($exam_num_arr){?>
			<?foreach($exam_num_arr as $tkey=>$tval){?>
			<col style="" />
			<?}?>
			<?}?>
			<col style="width: 7%;" />
			<col style="width: 7%;" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>등록번호</th>
				<th>이름</th>
				<th>면허번호</th>
				<th>소속</th>
				<?if($exam_num_arr){?>
				<?foreach($exam_num_arr as $tkey=>$tval){?>
				<th>문제<?=$tval?>(<?=$exam_score_arr[$tkey]?>)</th>
				<?}?>
				<?}?>
				<th>결과</th>
				<th>제출일</th>
			</tr>
		</thead>
		<tbody>
			<?
				$n=1;
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				$answer_ok=0;
				$total_score=0;
				
			?>
			<tr>
				<td><?=$virtualRecordNo?></td>
				<td><?=$d['etc_field2']?></td>
				<td><?if($d['country']=='K'){?><?=$d['name_kr']?><?}else{?><?=$d['name_eng']?><?}?></td>
				<td><?=$d['license_number']?></td>
				<td><?if($d['country']=='K'){?><?=$d['aff_kor']?><?}else{?><?=$d['aff_eng']?><?}?></td>
				<?if($exam_num_arr){?>
				<?foreach($exam_num_arr as $tkey=>$tval){?>
				<td><span style="color:<?=$_EXAM['exam_result_color'][$d['exam_result'.$tval]]?>"><?=$_EXAM['exam_result'][$d['exam_result'.$tval]]?></span></td>
				<?
					if($d['exam_result'.$tval]=='Y'){
						 if($category=='A'){
							$answer_ok++;
						 }else if($category=='B'){
							$answer_ok++;
							$total_score += $exam_score_arr[$tkey];
						 }
					}
				}	
				?>
				<?}?>
				<td>
				<?
				if($category=='A'){
					echo "정답수 : ".$answer_ok;
				}else{
					echo $answer_ok;
				}
				?>
				</td>
				<td><?=date("m.d H:i",$d['signdate'])?></td>
			</tr>
			<?$n++;$virtualRecordNo--;}?>
		</tbody>
	</table>
	<?
		if($add_search2) $search_url .= $add_search2;
		if($sort_field) $search_url .= "&sort_field=".$sort_field;
		if($orderby) $search_url .= "&orderby=".$orderby;
		if($chkday) $search_url .= "&chkday=".$chkday;

		$excel_kind = "exam_result"; //엑셀백업 구분값
	?>
	<div class="btnArea posRel">
		<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.page.php"?>						
	</div>
</div> 
<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.footer.php"?>		

    
 