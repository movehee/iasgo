<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	
	
	
?>
<link rel='stylesheet' type='text/css' href='/css/tree.css'/>

<div >
	<div class="btn" style="float:left;">
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
</div>
<div style="clear:both;"></div>
<div class="btn tp5" style="float:left;">
	<a href="/status/room.php?ev_date=<?=$ev_date?>" class="">ROOM 현황</a></li>
	<a href="/status/login_list.php?ev_date=<?=$ev_date?>" class="btnSky">Login 현황</a></li>
	<a href="/status/country_list.php?ev_date=<?=$ev_date?>" class="">국가별 현황</a></li>
</div>
<div style="clear:both;"></div>

<div style="float:right;">
	<span class="btnAdmin medium green"><button type="button" onclick="location.href='excel_login_list.php?ev_date=<?=$ev_date?>'">Excel backup</button></span>
</div>


<br />
<div class="contents tp10">
	<table style="width:100%;">
		<tr>
			<td valign="top" style="width:49%;">
				<?
					$num_per_page = 50;
					if($li_page) $num_per_page = $li_page;

					$query = "select count(*) from registration_tbl where login_day".$ev_date.">0 and country='K' "; // and member_level!='M' and classification not in ('C','M','Y')
					$totalRecord=$conn->getOne($query);

					if(DB::isError($totalRecord)) die($totalRecord->getMessage());
					$pageNav=new Page($page,$totalRecord,$num_per_page);
					$totalPage = $pageNav->getTotalPage();
					$firstRecord = $pageNav->getFirstRecordInPage();
				?>
				<div class="al" style="font-size:22px;font-weight:bold;">- 국내 (<?=$totalRecord?>)</div>
				<table class="tblDef">
					<colgroup>
						<col style="width: 6%;" />
						<col style="width: 20%;" />
						<col style="width: 20%;" />
						<col />
						<col style="width: 6%;" />
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>Country</th>
							<th>Name</th>
							<th>Affiliation</th>
							<th>Device</th>
						</tr>
					</thead>
					<tbody>
						<?
							

							$query = "select * from registration_tbl where login_day".$ev_date.">0 and country='K' ";
							$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
							$result=$conn->query($query);
							if(DB::isError($result)) die($result->getMessage());

							$virtualRecordNo=$pageNav->getVirtualRecordNoInPage($totalRecord);
							$blockNav = new Block("", $totalPage, $page_per_block);
							$totalBlock = $blockNav->getTotalBlock();
							$blockNav->setBlock($page);
							$block = $blockNav->getBlock();
							$firstPageInBlock = $blockNav->getFirstPageInBlock();
							$lastPageInBlock = $blockNav->getLastPageInBlock();
							if($block >= $totalBlock) $lastPageInBlock = $totalPage;

							$n=1;
							while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
						?>
						<tr>
							<td><?=$virtualRecordNo?></td>
							<td><?=$d['etc_field1']?></td>
							<td><?=$d['name_kr']?></td>
							<td class="al"><?=$d['aff_kor']?></td>
							<td><?=$_Login['login_kind'][$d['login_kind']]?></td>
						</tr>
						<?$virtualRecordNo--;}?>
						
					</tbody>
				</table>
				<?
					if($add_search2) $search_url .= $add_search2;
					if($sort_field) $search_url .= "&sort_field=".$sort_field;
					if($ev_date) $search_url .= "&ev_date=".$ev_date;

					$excel_kind = "exam_result"; //엑셀백업 구분값
				?>
				<div class="btnArea ">
					<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.page.php"?>						
				</div>
			</td>
			<td width="2%"></td>
			<td valign="top" style="width:49%;">
				<?
					$Tcnt_F = $conn->getOne("select count(*) from registration_tbl where login_day".$ev_date.">0 and country='F' and member_level!='M' and classification not in ('C','M','Y')");
				?>
				<div class="al" style="font-size:22px;font-weight:bold;">- 국외(<?=$Tcnt_F?>)</div>
				<table class="tblDef">
					<colgroup>
						<col style="width: 6%;" />
						<col style="width: 20%;" />
						<col style="width: 20%;" />
						<col />
						<col style="width: 6%;" />
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>Country</th>
							<th>Name</th>
							<th>Affiliation</th>
							<th>Device</th>
						</tr>
					</thead>
					<tbody>
						
						<?
							$query = "select * from registration_tbl where login_day".$ev_date.">0 and country='F' and member_level!='M' and classification not in ('C','M','Y')";
							$result=$conn->query($query);
							if(DB::isError($result)) die($result->getMessage());

							$n=1;
							while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
						?>
						<tr>
							<td><?=$n?></td>
							<td><?=$d['etc_field1']?></td>
							<td><?=$d['name_eng']?></td>
							<td class="al"><?=stripslashes($d['aff_eng'])?></td>
							<td><?=$_Login['login_kind'][$d['login_kind']]?></td>
						</tr>
						<?$n++;}?>
					
					</tbody>
				</table>	
			</td>
		</tr>
	</table>
	
	
</div>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.footer.php';
?>