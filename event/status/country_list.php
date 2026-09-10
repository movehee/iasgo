<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	
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
	<a href="/status/login_list.php?ev_date=<?=$ev_date?>" class="">Login 현황</a></li>
	<a href="/status/country_list.php?ev_date=<?=$ev_date?>" class="btnSky">국가별 현황</a></li>
</div>
<div style="clear:both;"></div>

<div style="float:right;">
	<span class="btnAdmin medium green"><button type="button" onclick="location.href='excel_country_list.php?ev_date=<?=$ev_date?>'">Excel backup</button></span>
</div>

<br />
<div class="contents tp10">
	<table class="tblDef">
		<colgroup>
			<col style="width: 5%;" />
			<col />
			<col style="width: 20%;" />
			
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>Country</th>
				<th>Count</th>
			</tr>
		</thead>
		<tbody>
			<?
				$query = "select etc_field1,Tcnt from (";
				$query .= "select etc_field1,count(etc_field1) as Tcnt from registration_tbl where login_day".$ev_date.">0 and etc_field1 is not null and etc_field1!='' and del='N' group by etc_field1 ";
				$query .= ") A order by Tcnt desc";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());

				$n=1;
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td><?=$n?></td>
				<td><?=$d['etc_field1']?></td>
				<td><?=$d['Tcnt']?></td>
			</tr>
			<?$n++;}?>
		
		</tbody>
	</table>
	
	
</div>
<?	
	include_once $_SERVER['DOCUMENT_ROOT'].'include.footer.php';
?>