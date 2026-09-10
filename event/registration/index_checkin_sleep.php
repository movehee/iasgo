<?include $_SERVER['DOCUMENT_ROOT']."/include.header.php"?>
<?
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';

	$workshop_manager_query = "select * from workshop_manager";
	$workshop_manager_result = $conn->query($workshop_manager_query);
	$workshop_manager_result->fetchInto(&$manager,DB_FETCHMODE_ASSOC);
	$workshop_manager_result->free();
	
	
	if($manager['edate']){
		$chkdate = strtotime($manager['edate'])-strtotime($manager['sdate']);
		$date_count = date("d",$chkdate);
	}else{
		$date_count = 1;	
	}
	$ex_sdate = explode("-",$manager['sdate']);
	
	
	$num_per_page = 10;
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = " order by sid desc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;


	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	
	
	$session_date2 = "2020-11-29";
	$_TIME['session']['2'] = array(
		'3' => array( $session_date2." 13:00", $session_date2." 17:55" )
	);

	if(!$result_code) $result_code='1';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='key'){
					$search_query[] = " t1.usid = '".$tval."' ";
				}else if($tkey=='program_day1'){
					$day_query[] = " t1.day ='1'";
				}else if($tkey=='program_day2'){
					$day_query[] = " t1.day ='2'";
				}else if($tkey=='program_day3'){
					$day_query[] = " t1.day ='3'";
				}else if($tkey=='program_day4'){
					$day_query[] = " t1.day ='4'";
				}else if(strpos($tkey,"_sdate")!==false || strpos($tkey,"_edate")!==false){
					$inout_query[] = " t1.$tkey>0";
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
			}
			$search_url .= "&$tkey=".$tval;
		}
	}
	if($day_query){
		$search_query[] = " (".implode(" or ",$day_query).")";
	}
	if($inout_query){
		$search_query[] = " (".implode(" and ",$inout_query).")";
	}

	if($li_page) $search_url .= "&li_page=".$li_page;
	$search_url .= "&result_code=".$result_code;
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and t2.sleep_chk='Y' and t1.day='2'";
	}else{
		$fsql = " where del='N' and t2.sleep_chk='Y' and t1.day='2'";
	}


	$pass_sid_arr = "'1','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','35','36','700','701','702','703','704','705','706','707','708','709','710','711','712','713','714','715','717','716','720','722','723','724','725','34','37','816','815','814','813','812','811','810','809','808','807','806','805','804','803','802','801','800','799','798','797','796','795','794','793','792','791','790','789','788','787','786','785','784','783','782','781','780','779','778','777','776','775','774','773','772','771','770','769','768','767','766','765','764','763','762','761','760','759','758','757','756','755','754','753','752','751','750','749','748','747','746','745','744','743','742','741','740','739','738','737','736','735','734','733','732','731','730','729','728','727','726','721'";
	
	$query = "select count(*) from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid " . $fsql;
	//$query .= " and t1.usid not in ($pass_sid_arr)";
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		//$query .= " and chking!='Y' ";
	}

	
	$totalRecord=$conn->getOne($query);
	$num_per_page = 50;
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();
	
	$query = "select t1.*,t2.license_number,t2.name_kr,t2.sid as usid from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid " . $fsql;
	//$query .= " and t1.day='2' and t1.score='4'";
	//$query .= " and t1.usid not in ($pass_sid_arr)";
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		//$query .= " and chking!='Y'";

		//$query .= " and score='3'  and t1.day='3'";
	}
	$query .= "  order by t1.day desc, sid asc"; //and t2.day='2' and t1.score='6' //id asc, t1.day asc, 
	if($_SERVER['REMOTE_ADDR']!='218.235.94.2220'){
		$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
	}
	//echo $query;
	
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
	
	$time_max_count = count($_TIME['session']['1']);
	for($i=1;$i<=count($_TIME['session']);$i++){
		if($time_max_count<count($_TIME['session'][$i])){
			$time_max_count = count($_TIME['session'][$i]);
		}
	}
?>
<div class="searchArea">
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
	<input type="hidden" name="result_code" value="<?=$result_code?>">
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
						<th>면허번호</th>
						<td class="al"><input type="text" name="license_number" id="license_number" value="<?=$license_number?>" style="width:95%;"></td>
					</tr>
					<!-- <tr>
						<th>행사</th>
						<td class="al multi" colspan="7" style="font-size:19px;">
							<input type="checkbox" style="width:21px;height:21px;" name="program_day1" id="program_day1" value="Y" <?if($program_day1=='Y'){?>checked<?}?>> <label for="program_day1">11/28</label>
							<input type="checkbox" style="width:21px;height:21px;" name="program_day2" id="program_day2" value="Y" <?if($program_day2=='Y'){?>checked<?}?>> <label for="program_day2">11/29</label>
						</td>
						<th>Sid</th>
						<td class="al"><input type="text" name="key" id="key" value="<?=$key?>" style="width:100px;"></td>
					</tr>
					<tr>
						<th>세션</th>
						<td class="al multi" colspan="9">
							<div>
							<?for($i=1;$i<=$time_max_count;$i++){?>
							<input type="checkbox" name="s<?=$i?>_sdate" id="s<?=$i?>_sdate" value="Y" <?if(${'s'.$i.'_sdate'}=='Y'){?>checked<?}?>> <label for="s<?=$i?>_sdate">Session<?=$i?> 입장</a>
							<input type="checkbox" name="s<?=$i?>_edate" id="s<?=$i?>_edate" value="Y" <?if(${'s'.$i.'_edate'}=='Y'){?>checked<?}?>> <label for="s<?=$i?>_edate">Session<?=$i?> 퇴장</a>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<? if($i=='5') echo "</div><div>";}?>
							</div>
						</td>
					</tr> -->
					
				</tbody>
			</table>
			<div class="btn btnArea">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="검색초기화" class="btnGrey" onclick="location.href='<?=$PHP_SELF?>?result_code=<?=$exam_result?>'">
				<input type="button" value="Excel Backup" onclick="location.href='excel_backup_sleep.php'" class="btnMint initialism fade_open btn btn-success ex_btn">
			</div>
		</fieldset>
	</form>
</div>
<br />
<div style="clear:both;">
	<!-- <div style="float:left;">
		<span class="rBtnAdmin medium white"><button type="button" onclick="location.href='index.php'">사전등록 명단</button></span>
		<span class="rBtnAdmin medium blue"><button type="button" onclick="location.href='index_checkin.php'">입 출 확 인</button></span>
	</div> -->
	<!-- <div style="float:right;">
		<span class="rBtnAdmin large darkPink <?if($day!='1'){?>empty<?}?>"><button type="button" onclick="location.href='<?=$PHP_SELF?>?day=1'">17 일</button></span>
		<span class="rBtnAdmin large darkPink <?if($day!='2'){?>empty<?}?>"><button type="button" onclick="location.href='<?=$PHP_SELF?>?day=2'">18 일</button></span>
		<span class="rBtnAdmin large darkPink <?if($day!='2'){?>empty<?}?>"><button type="button" onclick="location.href='<?=$PHP_SELF?>?day=2'">19 일</button></span>
	</div> -->
</div>
<div class="bp10"  style="clear:both;"></div>
<script>
	function change_paystat(str,sid,kind){
		$.ajax({
			type:"POST",
			url:"/registration/stat_change.php",
			data:"str="+str+"&sid="+sid+"&kind="+kind,
			success:function(msg){
			}
		});
	}
</script>
<table class="tblDef" >
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 8%;">
		<col style="width: 8%;">
		<col style="">
		<?for($i=3;$i<=3;$i++){?>
		<col style="width: 15%;">
		<col style="width: 15%;">
		<?}?>
		<col style="width: 6%;">
		<col style="width: 6%;">
		<col style="width: 3%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>행사일</th>
			<th>성명</th>
			<th>면허번호</th>
			<!-- <th>강의실 입장</th> -->
			<th>수면다윈검사 입장</th>
			<th>수면다윈검사 퇴장</th>
			<!-- <th>퇴장</th> -->
			<th>체류시간</th>
			<th>점수</th>
			<th>조정</th>
			<!-- <th>상세</th> -->
		</tr>
	</thead>
	<tbody>
		<?
			$n=1;
		
			while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				
				unset($stay_hours);
				unset($stay_min);
				unset($score);
				unset($sum_score);
				unset($sum_times);
				for($i=3;$i<=3;$i++){ //세션갯수만큼
					${"mm".$i}=0;
					${"s".$i."_sdate"} = "";
					${"s".$i."_edate"} = "";

					${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
					${"s".$i."_edate"} = $d['s'.$i.'_edate'];
					if(strtotime($_TIME['session'][$d['day']][$i][0])>$d['s'.$i.'_sdate'] && $d['s'.$i.'_sdate']){
						${"s".$i."_sdate"} = strtotime($_TIME['session'][$d['day']][$i][0]);
					}
					if(strtotime($_TIME['session'][$d['day']][$i][1])<$d['s'.$i.'_edate'] && $d['s'.$i.'_edate']){
						${"s".$i."_edate"} = strtotime($_TIME['session'][$d['day']][$i][1]);
					}
					if(${"s".$i."_sdate"}>0 && ${"s".$i."_edate"}>0 && ${"s".$i."_edate"}>strtotime($_TIME['session'][$d['day']][$i][0])){
						${"s".$i."_time"} = ${"s".$i."_edate"}-${"s".$i."_sdate"};
						${"mm".$i} = (${"s".$i."_time"}/60);
					}
					$sum_times += (${"mm".$i});
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
					if($score>6){
						$score = 6;
					}
				}

		?>
		<tr <?if($d['modify']=='Y'){?>style="background:#EDEDED"<?}?>>
			<td><?=$virtualRecordNo?></td>
			<td><?=date("m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['day']-1), $ex_sdate[0]));?></td>
			<td><?=$d['name_kr']?><?if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){?> / <?=$d['usid']?><?}?></td>
			<td><?=$d['license_number']?></td>
			
			
			<?for($i=3;$i<=3;$i++){?>
			<td <?if($i%2==0){?>style="background:#FEFFE1;"<?}?>>
				<?if($d['s'.$i.'_sdate']>0){?><a href="javascript:popup_call('registration/session_time','sid=<?=$d['sid']?>&day=<?=$d['day']?>')"><?=date("H:i",$d['s'.$i.'_sdate'])?></a><?}?>
			</td>
			<td <?if($i%2==0){?>style="background:#FEFFE1;"<?}?>>
				<?if($d['s'.$i.'_edate']>0){?><a href="javascript:popup_call('registration/session_time','sid=<?=$d['sid']?>&day=<?=$d['day']?>')"><?=date("H:i",$d['s'.$i.'_edate'])?></a><?}?>
			</td>
			<?}?>
			<td><?=$stay_hours.":".$stay_min?></td>
			
			<td >
			<?
				if($score>=2){
					echo $score;
				}
			?>
			</td>
			<td><i class="far fa-clock" style="cursor:pointer;font-size:18px;" onclick="popup_call('registration/session_time','sid=<?=$d['sid']?>&day=<?=$d['day']?>')"></i></td>
			<!-- <td><span class="rBtnAdmin small darkPink"><button type="button" onclick="popup_call('registration/checkin_list','sid=<?=$d['usid']?>&day=<?=$day?>')">View</button></span></td> -->
		</tr>
		<?$n++;?>
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
 