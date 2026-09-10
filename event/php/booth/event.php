<?include "./../header.php";?>

<?
/*if($code == "korl2019") {
	mysqli_query($conn, "insert into booth_temp (regist_sid, deviceid) values ('$regist_sid', '$deviceid')");
}*/


$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


if($barcode) $user_sid = $barcode;
else if($regist_sid) $user_sid = $regist_sid;


//print_r($_GET);

$query = "SELECT a.image,a.booth_num,b.sid,b.signdate,a.id FROM booth_tbl a left join booth_event_tbl b  on a.sid = b.booth_sid and b.user_sid='".$user_sid."' where a.code='".$code."' and a.del='N' and a.event_YN ='Y' ";	


$query .= " order by b.sid desc,  a.orderby asc";
$result = mysqli_query($conn, $query);
$vip=-1;
//echo $query;
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no" />
<style>
ul.booth {overflow:hidden;padding:0 10px 10px;list-style: none;}
ul.booth li {float:left;width:50%;padding-top:10px;box-sizing:border-box;}
ul.booth li:nth-child(odd) {padding-right:5px;}
ul.booth li:nth-child(even) {padding-left:5px;}

ul.booth a {position:relative;display:block;border:1px solid #cdcdcd;}
ul.booth img {display:block;width:100%;}

ul.booth li.on span {display:block;}
ul.booth li .checktime{display:none;color:#ffffff; width: 100%; position: absolute; text-align: center; top: 80%;text-indent: 0;  background: none;}
ul.booth li .boothNo{display:block;color: #ffffff; position: absolute; top:0; left:0;background-color: #383838;padding: 10px; 20px; font-size:25px;}
 
ul.booth li.on .checkbg,
ul.booth li.on .checktime {display:block;}
</style>

<?
if($event_col['language']=="Kor"){?>
<style>
ul.booth span {display:none;position:absolute;left:0;top:0;width:100%;height:100%;text-indent:-10000px;background:rgba(0,0,0,.7) url('/image/booth_checked.png') center center no-repeat;background-size:140px;}
</style>
<?}else{?>
<style>
ul.booth span {display:none;position:absolute;left:0;top:0;width:100%;height:100%;text-indent:-10000px;background:rgba(0,0,0,.7) url('/image/booth_checked2.png') center center no-repeat;background-size:140px;}
</style>
<?}?>

<?if(!$include){?>
<div class="titArea">
	<h2><?=$setting_col['event_txt']?></h2>
	<p class="fixedBtn">
		<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>	
	</p>
</div>
<?}?>



<ul class="booth">
	<?while(is_array($col = mysqli_fetch_array($result))){?>
		<li <?if($col['sid']){?> class="on"<?}?>><a href="javascript:void(0)">
			<img src="/upload/booth/<?=$col['image']?>" alt="SANOFI" />
			<span class="checked checkbg">행사참여완료</span>
			<?if($setting_col['booth_event_num_YN']=="1"){?>
				<div class="boothNo"><?=$col['booth_num']?></div>
			<?}?>
			<?if($col['sid'] && $event_col['language']=="Kor"){?>
				<p class="checktime"><?=date('H시 i분',$col['signdate'])?> 참여완료</p>
			<?}else if($col['sid']){?>
				<p class="checktime"><?=date('M, d h:i',$col['signdate'])?></p>
			<?}?>

		</a></li>
	<?}?>
	
</ul>

<!--
<?if(stristr($_SERVER['REMOTE_ADDR'], "218.235.94")){?>
<h3>우리아이피에서만 보임</h3>

<span class="btn">
<button value="해당 행사 이벤트 모두삭제"></button>
<a href="" class="btnDef" title="부스등록" onclick="javascript:add('<?=$code?>')" ><i class="fas fa-plus-circle"></i>부스 등록</a>

<a href="" onclick="javascript:modify('<?=$code?>','<?=$d['sid']?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
</span>
<?}?>
-->

<?include "./../footer.php";?>