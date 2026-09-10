<?include "./../header.php";?>
<?
$setting_query = "SELECT * FROM session_set_tbl where code='".$code."'";
//echo $setting_query;
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
?>
<?if($event_col['gubun']=="WEB"){?>
<p class="toptit<?=$event_col['gubun_val']?$event_col['gubun_val']:"";?>"><?=strtoupper($setting_col['Agenda_txt'])?></p>
<?}?>
<?
if(empty($page)) {

	
	$query="select day from agenda_tbl where code='".$code."' and eventdate='".mktime(0, 0, 0, date("m"), date("d"), date("Y")."'")."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
	$page = $d['day'];

	if(empty($page))
		$page=1;
}
	
$result = mysqli_query($conn, "select count(*) cnt from agenda_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);


$cnt = $row['cnt'];

?>
<?if($cnt>1){
	$query="SELECT * FROM agenda_tbl where code='".$code."' and del='N'";
	$result = mysqli_query($conn, $query);
?>
<ul style="position:relative;width:100%; margin:0 auto; text-align:center;z-index:10; letter-spacing: -0.2px;">
<?while(is_array($col = mysqli_fetch_array($result))){?>
	<li onclick="javascript:location.href='./view.php?code=<?=$code?>&page=<?=$col['day']?>'" style="border-radius: 15px 15px 0px 0px; width:<?=100/$cnt?>%;float:left;height:50px;line-height:50px;text-align:center;font-size:14px;<?if($page==$col['day']){?>background-color:<?=$css_col['agenda_bg'.$col['day'].'_on']?>;color:<?=$css_col['agenda_font'.$col['day'].'_on']?>;<?}else{?>background-color:<?=$css_col['agenda_bg'.$col['day']]?>;color:<?=$css_col['agenda_font'.$col['day']]?>;<?}?>"><?=$col['name']?></li>
<?}?>
</ul>
<?}?>
<?
	$query="SELECT * FROM agenda_tbl where code='".$code."' and day='".$page."' and del='N'";
	$result = mysqli_query($conn, $query);
	$col = mysqli_fetch_array($result);
?>
<div class="wrapper">
	<img src="/upload/agenda/<?=$col['image']?>" style="position:relative;width: 92%;margin-left:4%;margin-top:15px;margin-bottom:20px; height: auto;  " id="img1" >
</div>

<?include "./../footer2.php";?>