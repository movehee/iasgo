<?include "./../header.php";?>
<?
	$setting_query = "SELECT * FROM session_set_tbl where code='".$code."'";
	$setting_result = mysqli_query($conn, $setting_query);
	$setting_col = mysqli_fetch_array($setting_result);
?>
<?if($event_col['gubun']=="WEB"){?>
<p class="toptit<?=$event_col['gubun_val']?$event_col['gubun_val']:"";?>"><?=strtoupper($setting_col['Agenda_txt'])?></p>
<?}?>
<?

	if(!isset($tab)) {

		$query="select * from agenda_tbl where del='N' and code='".$code."' order by day";
		$result = mysqli_query($conn, $query);
		while(is_array($day_col = mysqli_fetch_array($result))){
			if(date('Y-m-d') == date("Y-m-d", $day_col['eventdate'])) {
				$tab = $day_col['sid'];
			}

			if(!isset($f_tab)) { $f_tab = $day_col['sid']; }

		}

		if($tab==""){
			$tab = $f_tab;
		}
	}

	



	$result = mysqli_query($conn, "select count(*) cnt from agenda_tbl where code='".$code."' and del='N'");
	$row = mysqli_fetch_array($result);

	$cnt = $row['cnt'];
	if($cnt>1)
	{
		$query="SELECT * FROM agenda_tbl where code='".$code."' and del='N' order by day";
		$result = mysqli_query($conn, $query);
?>
	<ul style="position:relative;width:100%; margin:0 auto; text-align:center;z-index:10; letter-spacing: -0.2px;">
	<?while(is_array($col = mysqli_fetch_array($result))){?>
		<li onclick="javascript:location.href='./view.php?code=<?=$code?>&tab=<?=$col['sid']?>'" style="border-radius: 15px 15px 0px 0px; width:<?=100/$cnt?>%;float:left;height:50px;line-height:50px;text-align:center;font-size:14px;<?if($tab==$col['sid']){?>background-color:<?=$css_col['agenda_bg'.$col['day'].'_on']?>;color:<?=$css_col['agenda_font'.$col['day'].'_on']?>;<?}else{?>background-color:<?=$css_col['agenda_bg'.$col['day']]?>;color:<?=$css_col['agenda_font'.$col['day']]?>;<?}?>"><?=$col['name']?></li>
	<?}?>
	</ul>
	<?}?>

<?
if($event_col['agenda_session'] == 'Y' ) { //해당페이지에서 세션 리스트들 보여줌
	 

	$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.tab='".$tab."' $query_str ";//and a.viewYN='Y' ";
	if($room){
		$query .= " and a.room='".$room."' ";
	}
	if($category){
		$query .= " and a.category1='".$category."' ";
	}
	$query .= " order by a.tab asc, a.orderby asc";
	$result = mysqli_query($conn, $query);
	?>
	<? if($cnt>1) {?><div style="padding-top:50px;"></div><?}?>
	<div class="wrapper">
		<?include "info.php";?>
	</div>
	<?
} else {

?>

<?
	$query="SELECT * FROM agenda_tbl where code='".$code."' and sid='".$tab."' and del='N'";
	$result = mysqli_query($conn, $query);
	$col = mysqli_fetch_array($result);
?>
<div class="wrapper">
	<img src="/upload/agenda/<?=$col['image']?>" style="position:relative;width: 92%;margin-left:4%;margin-top:15px;margin-bottom:20px; height: auto;  " id="img1" >
</div>

<?}?>

<?include "./../footer2.php";?>