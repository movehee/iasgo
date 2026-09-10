<?include $_SERVER['DOCUMENT_ROOT']."include.header.php"?>
<?
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$num_per_page = 50;
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = " order by sid desc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;


	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','kind');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}

	if(!$kind) $kind="A";

	
	

	if(!$result_code) $result_code='1';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='s_sid'){
					$search_query[] = " society_sid = '".$tval."' ";
				}else if($tkey=='regist_gubunA' || $tkey=='regist_gubunB' || $tkey=='regist_gubunC' || $tkey=='regist_gubunD' || $tkey=='regist_gubunE' || $tkey=='regist_gubunP' || $tkey=='regist_gubunG'  || $tkey=='regist_gubunZ'){
					if($tkey=='regist_gubunA') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunP') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunB') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunD') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunE') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunG') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunZ') $reg_gubun[] = $tval;
				}else if($tkey=='program_day1'){
					$search_query[] = " login1 like '%".$tval."%' ";
				}else if($tkey=='program_day2'){
					$search_query[] = " login2 like '%".$tval."%' ";
				}else if($tkey=='program_day3'){
					$search_query[] = " login3 like '%".$tval."%' ";
				}else if($tkey=='program_day4'){
					$search_query[] = " login4 like '%".$tval."%' ";
				}else if($tkey=='regist_kind'){
					$search_query[] = " reg_kind='".$tval."' ";
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
	$search_url .= "&kind=".$kind;

	if($kind=='A'){
		$login_sql = "login1='Y' or login2='Y'";
		$dd1=1;
		$dd2=2;
		$tt = "기본";
		$dt1 = "23";
		$dt2 = "24";
	}else{
		$login_sql = "login3='Y' or login4='Y'";
		$dd1=3;
		$dd2=4;
		$tt = "심화";
		$dt1 = "25";
		$dt2 = "26";
	}

	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and ($login_sql) and member_level!='M' ";
	}else{
		$fsql = " where del='N' and ($login_sql) and member_level!='M' ";
	}
	
	$query = "select count(*) from registration_tbl" .$fsql;

	$totalRecord=$conn->getOne($query);
	
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();
	
	$query = "select * from registration_tbl " .$fsql;
	$query .= $sort_sql;
	//$query .= " limit 100,10";
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
	
	
?>
<div class="searchArea">
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
	<input type="hidden" name="kind" value="<?=$kind?>">
		<fieldset>
			<legend>상세 검색</legend>
			<table class="tblDef inputTbl">
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
				</colgroup>
				<tbody>
					<tr>
						<th>ID</th>
						<td class="al"><input type="text" name="id" id="id" value="<?=$id?>" style="width:95%;"></td>
						<th>성명</th>
						<td class="al"><input type="text" name="name_kr" id="name_kr" value="<?=$name_kr?>" style="width:95%;"></td>
						<th>소속</th>
						<td class="al"><input type="text" name="aff_kor" id="aff_kor" value="<?=$aff_kor?>" style="width:95%;"></td>
						<th>E-mail</th>
						<td class="al"><input type="text" name="email" id="email" value="<?=$email?>" style="width:95%;"></td>
						<th>비밀번호</th>
						<td class="al"><input type="text" name="license_number" id="license_number" value="<?=$license_number?>" style="width:95%;"></td>
					</tr>
				</tbody>
			</table>
			<div class="btn btnArea">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="검색초기화" class="btnGrey" onclick="location.href='<?=$PHP_SELF?>?result_code=<?=$exam_result?>'">
				<input type="button" value="Excel Backup" onclick="location.href='excel_dedicated.php?<?=$search_url?>'" class="btnGreen2 initialism fade_open btn btn-success ex_btn">

			</div>
		</fieldset>
	</form>
</div>
<div>
	<div class="btn bp5" style="float:left;">
		<div class="btn" style="float:left;clear:both;margin-top:7px;">
			<a href="<?=$PHP_SELF?>?kind=A" <?if($kind=='A'){?>class="btnRed"<?}?>>기본과정</a></li>
			<a href="<?=$PHP_SELF?>?kind=B" <?if($kind=='B'){?>class="btnRed"<?}?>>심화과정</a></li>
		</div>
		
	</div>
</div>
<div class="contents">
	<table class="tblDef">
		<colgroup>
			<col style="width: 4%;" />
			<col style="width: 5%;" />
			<col style="width: 6%;" />
			<col style="width: 8%;" />
			<col style="width: 5%;" />
			<col style="width: 5%;" />
			<col style="width: 5%;" />
			<col style="width:" />
			<col style="width: 12%;" />
			<col style="width: 9%;" />
			<col style="width: 9%;" />
			<col style="width: 9%;" />
			<col style="width: 9%;" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>등록종류</th>
				<th>등록구분</th>
				<th>전문의구분</th>
				<!-- <th>연차</th> -->
				<th><?=admin_orderby("ID","id",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("성명","name_kr",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("면허번호","license_number",$sort_field,$orderby,$search_url)?></th>	
				<th><?=admin_orderby("소속","aff_kor",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("E-mail","email",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("연락처","cell",$sort_field,$orderby,$search_url)?></th>
				<th>교육과정</th>
				<th><?=$dt1?>일</th>
				<th><?=$dt2?>일</th>
				<th>감염관리 전담인력 교육시간</th>
			</tr>
		</thead>
		<tbody>
			<?
				
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td><?=$virtualRecordNo?></td>
				<td><?=$_REG['class_kind'][$d['classification']]?></td>
				<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
				<td><?=$_REG['gubun1'][$d['gubun1']]?><?if($d['gubun2']){?><br />(<?=$_REG['gubun2'][$d['gubun2']]?>)<?}?></td>
				<!-- <td><?=$d['major_year']?></td> -->
				<td><?=$d['id']?></td>
				<td><?=$d['name_kr']?></td>
				
				
				<td><?=$d['license_number']?></td>
				
				<td><?=$d['aff_kor']?></td>
				<td><?=$d['email']?></td>
				<td><?=$d['cell']?></td>
				<td><?=$tt?>과정</td>
				<td>
				<?
					$time1_query = "select * from checkin_tbl where usid='".$d['sid']."' and day='$dd1'";
					$result_t1 = $conn->query($time1_query);
					if(DB::isError($result_t1)) {
					  die($result_t1->getMessage());
					}
					$result_t1->fetchInto(&$t1,DB_FETCHMODE_ASSOC);
					$result_t1->free();
					$time_max_count=2;
					unset($stay_hours);
					unset($stay_min);
					unset($score);
					unset($score1);
					unset($sum_score);
					unset($sum_times);
					for($i=1;$i<=$time_max_count;$i++){ //세션갯수만큼

						${"mm".$i}=0;
						${"s".$i."_sdate"} = "";
						${"s".$i."_edate"} = "";

						//${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
						${"s".$i."_sdate"} = strtotime(date("Y-m-d H:i",$t1['s'.$i.'_sdate']));
						${"s".$i."_edate"} = $t1['s'.$i.'_edate'];
						if(strtotime($_TIME['session'][$t1['day']][$i][0])>$t1['s'.$i.'_sdate'] && $t1['s'.$i.'_sdate']){
							${"s".$i."_sdate"} = strtotime($_TIME['session'][$t1['day']][$i][0]);
						}
						if(strtotime($_TIME['session'][$t1['day']][$i][1])<$t1['s'.$i.'_edate'] && $t1['s'.$i.'_edate']){
							${"s".$i."_edate"} = strtotime($_TIME['session'][$t1['day']][$i][1]);
						}
						if(${"s".$i."_sdate"}>0 && ${"s".$i."_edate"}>0 && ${"s".$i."_edate"}>strtotime($_TIME['session'][$t1['day']][$i][0])){
							${"s".$i."_time"} = ${"s".$i."_edate"}-${"s".$i."_sdate"};
							${"mm".$i} = (${"s".$i."_time"}/60);
						}
						if(${"mm".$i}>0){
							$sum_times += (${"mm".$i});
						}
					}
					
					$sum_score = floor($sum_times);
					
					if($sum_score>0){
						if($sum_score>=60){
							$stay_hours = sprintf("%02d", floor($sum_score/60));
							$stay_min = sprintf("%02d", floor($sum_score%60));
						}else{
							$stay_hours = 0;
							$stay_min = sprintf("%02d", floor($sum_score%60));
						}
						$score = floor($stay_hours);
				
					}
					echo $stay_hours.":".$stay_min;

					if($stay_hours>=7){
						$score1 = 8;
					}else{
						$score1 = $stay_hours;
					}
				?>
				</td>
				
				<td>
				<?
					$time2_query = "select * from checkin_tbl where usid='".$d['sid']."' and day='$dd2'";
					
					$result_t2 = $conn->query($time2_query);
					if(DB::isError($result_t2)) {
					  die($result_t2->getMessage());
					}
					$result_t2->fetchInto(&$t2,DB_FETCHMODE_ASSOC);
					$result_t2->free();
					if($t2['day']=='2'){
						$time_max_count=3;
					}else{
						$time_max_count=2;
					}
					
					unset($stay_hours);
					unset($stay_min);
					unset($score);
					unset($score2);
					unset($sum_score);
					unset($sum_times);
					for($i=1;$i<=$time_max_count;$i++){ //세션갯수만큼

						${"mm".$i}=0;
						${"s".$i."_sdate"} = "";
						${"s".$i."_edate"} = "";

						//${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
						${"s".$i."_sdate"} = strtotime(date("Y-m-d H:i",$t2['s'.$i.'_sdate']));
						${"s".$i."_edate"} = $t2['s'.$i.'_edate'];
						if(strtotime($_TIME['session'][$t2['day']][$i][0])>$t2['s'.$i.'_sdate'] && $t2['s'.$i.'_sdate']){
							${"s".$i."_sdate"} = strtotime($_TIME['session'][$t2['day']][$i][0]);
						}
						if(strtotime($_TIME['session'][$t2['day']][$i][1])<$t2['s'.$i.'_edate'] && $t2['s'.$i.'_edate']){
							${"s".$i."_edate"} = strtotime($_TIME['session'][$t2['day']][$i][1]);
						}
						if(${"s".$i."_sdate"}>0 && ${"s".$i."_edate"}>0 && ${"s".$i."_edate"}>strtotime($_TIME['session'][$t2['day']][$i][0])){
							${"s".$i."_time"} = ${"s".$i."_edate"}-${"s".$i."_sdate"};
							${"mm".$i} = (${"s".$i."_time"}/60);
						}
						if(${"mm".$i}>0){
							$sum_times += (${"mm".$i});
						}
					}
					
					$sum_score = floor($sum_times);
					
					if($sum_score>0){
						if($sum_score>=60){
							$stay_hours = sprintf("%02d", floor($sum_score/60));
							$stay_min = sprintf("%02d", floor($sum_score%60));
						}else{
							$stay_hours = 0;
							$stay_min = sprintf("%02d", floor($sum_score%60));
						}
						$score = floor($stay_hours);
				
					}
					echo $stay_hours.":".$stay_min;
					if($stay_hours>=7){
						$score2 = 8;
					}else{
						$score2 = $stay_hours;
					}
				?>
				</td>
				<td><?=$score1+$score2?></td>
			</tr>
			<?$virtualRecordNo--;}?>
		</tbody>
	</table>
	<?
		if($add_search2) $search_url .= $add_search2;
		if($sort_field) $search_url .= "&sort_field=".$sort_field;
		if($orderby) $search_url .= "&orderby=".$orderby;

		$excel_kind = "exam_result"; //엑셀백업 구분값
	?>
	<div class="btnArea posRel">
		<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.page.php"?>						
	</div>
</div> 
<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.footer.php"?>		

    
 