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
	
	$sort_sql = " order by signdate desc";
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
	
	$fsql = " where day='$chkday'"; 
	
	
	$query = "select count(*) from room_statistics_tbl" .$fsql;
	//master_echo($query);
	$totalRecord=$conn->getOne($query);
	
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();
	
	$query = "select * from room_statistics_tbl " .$fsql;
	$query .= $sort_sql;
	//$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
	
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


	if(!$set_time) $set_time=5;

	$interval_time = ($set_time*60000);
	
?>
<script>
	var day="<?=$chkday?>";
	var interval_time = "<?=$interval_time?>";
	$(document).ready(function(){
			load_process = setInterval( function () {
			var record_start = $('#record_start').val();
			//alert($('#record_start').is(':checked'))
			if($('#record_start').is(':checked')==true){
				$(".load_area").load("auto_record_load.php?chkday="+day);
			}

			//alert($('#record_start').val())
		}, interval_time); //300000
	});
</script>
<div class="tp20"></div>


<div >
	<div class="btn" style="float:left;">
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&chkday=<?=$date?>" <?if($chkday==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
</div>

<div style="clear:both;padding-bottom:10px;"></div>
<div>
	<form name="exam_termF" id="exam_termF" method="post" action="<?=$PHP_SELF?>">
	<input type="hidden" name="chkday" value="<?=$chkday?>">
	<table class="tblDef">
		<tr>
			<th style="width:140px;">기간간격</th>
			<td class="al">	
				<div class="btn" style="float:left;padding-left:10px;"> 
					<span class="rp30" style="font-size:19px;"><input type="text" name="set_time" id="set_time" value="<?=$set_time?>" style="width:60px;"> 분 간격으로 저장합니다. </span>
					<a href="javascript:document.exam_termF.submit();" class="btnGreen2 withIcon"><i class="far fa-save" style="font-size:18px;padding-top:0px;"></i>간격 저장하기</a>
					<div class="fcRed tp5 lp10" style="float:right;font-size:15px;">
						<input type="checkbox" name="record_start" id="record_start" value="Y" style="width:20px;height:20px;" <?if($record_start=='Y'){?>checked<?}?>> <label for="record_start">저장 프로세스를 시작합니다.</label>
					</div>
				</div>

				<div class="btn" style="float:right;"> 
					
					<a href="./excel_auto_record.php?chkday=<?=$chkday?>" class="btnGreen2 withIcon"><i class="far fa-save" style="font-size:18px;padding-top:0px;"></i>Excel Backup</a>
					
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>

<div class="contents tp10">
	<table class="tblDef">
		<colgroup>
			<col style="width: 4%;" />
			<col style="width: 4%;" />
			<col style="width: 4%;" />
			<?foreach($_CONFIG['room'] as $tkey=>$tval){?>
			<?if($chkday=='1') if($tkey!='1' && $tkey!='3' && $tkey!='5' && $tkey!='9') continue;?>
			<?if($chkday!='1')if($tkey!='1'  && $tkey!='3' && $tkey!='5' ) continue;?>
			<col style="width: %;" />
			<col style="width: %;" />
			<?}?>
			<col style="width: 5%;" />
		</colgroup>
		<thead>
			<tr>
				<th rowspan=2>No</th>
				<th colspan=2>Login</th>
				<?foreach($_CONFIG['room'] as $tkey=>$tval){?>
				<?if($chkday=='1') if($tkey!='1' && $tkey!='3' && $tkey!='5' && $tkey!='9') continue;?>
				<?if($chkday!='1')if($tkey!='1'  && $tkey!='3' && $tkey!='5' ) continue;?>
				<th colspan=2><?=$_Day['room_title'][$tkey]?></th>
				<?}?>
				<th rowspan=2><?=admin_orderby("저장일","signdate",$sort_field,$orderby,$search_url)?></th>
			</tr>
			<tr>
				<th>국내</th>
				<th>국외</th>
				<?foreach($_CONFIG['room'] as $tkey=>$tval){?>
				<?if($chkday=='1') if($tkey!='1' && $tkey!='3' && $tkey!='5' && $tkey!='9') continue;?>
				<?if($chkday!='1')if($tkey!='1'  && $tkey!='3' && $tkey!='5' ) continue;?>
				<th>국내</th>
				<th>국외</th>
				<?}?>
			</tr>
		</thead>
		<tbody class="load_area">
			<?
				$n=1;
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td><?=$n?></td>
				<td><?=$d['login_K']?></td>
				<td><?=$d['login_F']?></td>
				<?foreach($_CONFIG['room'] as $tkey=>$tval){?>
				<?if($chkday=='1') if($tkey!='1' && $tkey!='3' && $tkey!='5' && $tkey!='9') continue;?>
				<?if($chkday!='1')if($tkey!='1'  && $tkey!='3' && $tkey!='5' ) continue;?>
				<td><?=$d['room'.$tkey.'_kor']?></td>
				<td><?=$d['room'.$tkey.'_eng']?></td>
				<?}?>
				<td><?=date('y.n.j H:i',$d['signdate'])?></td>
			</tr>
			<?$n++;$virtualRecordNo--;}?>
		</tbody>
	</table>
	<?
		if($add_search2) $search_url .= $add_search2;
		if($sort_field) $search_url .= "&sort_field=".$sort_field;
		if($orderby) $search_url .= "&orderby=".$orderby;

		$excel_kind = "exam_result"; //엑셀백업 구분값
	?>
	<!-- <div class="btnArea posRel">
		<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.page.php"?>						
	</div> -->
</div> 
<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.footer.php"?>		

    
 