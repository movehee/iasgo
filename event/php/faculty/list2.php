<?include "./../header.php";?>
<?
	$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
	$setting_result = mysqli_query($conn, $setting_query);
	$setting_col = mysqli_fetch_array($setting_result);


	
?>
<style>
dl.resultList ul.withFavor > li {position: relative;padding:10px 65px 10px 0;}
dl.resultList ul.withFavor a.favor {position: absolute;right: 20px;top: 50%;margin-top: -14px;}
dl.resultList a.photo {    overflow: hidden; position: relative;padding: 5px 15px 5px 15px;}
/*dl.resultList a.photo span  {overflow: hidden;position: relative;left: 15px;top: 50%;width: 28px;height: 28px;margin-top: -15px;border: 1px solid #ddd;border-radius:14px;} */
dl.resultList a.photo span {overflow: hidden; width: 60px; display: inline-block; vertical-align: middle;height: 60px; margin-right:10px; border: 1px solid #ddd; border-radius: 50%;}
dl.resultList a.photo span img {width: 100%;height: 100%;background-size:cover;}
/* dl.resultList a span.facultyInfo {   border-radius:0; border:none; display: inline-block;   overflow: hidden;   vertical-align: middle;  height: auto;     line-height: 16px;}
 */
a.favor,
a.favorTxt {height:15px;font-size:9px;padding:6px 3px!important; background:transparent;border:1px solid #ffb020; color:#ffb020 !important; }
a.favor i,
a.favorTxt i {display:block;text-align:center;}
a.favor.on,
a.favorTxt.on {  border:1px solid #ffb020;background-color:#ffb020;color:#fff !important;}

ul.facultyList {overflow: hidden;padding:45px 10px 10px;}
ul.facultyList li {float: left;width: 50%;padding: 10px 0 0 5px;box-sizing:border-box;}
ul.facultyList li:nth-child(odd) {clear: both;padding: 10px 5px 0 0;}
ul.facultyList a {color: #282828;width:100%!important;}
ul.facultyList span {display: block;}
ul.facultyList span.photo {    overflow: hidden;height: 210px;border: 1px solid #c9ccd4;margin-bottom: 5px;background: #fff url('/image/faculty_thumb.jpg') center center no-repeat;background-size: 75px;}
ul.facultyList span.photo img {display: block;width: 100%;height: 100%;}
ul.facultyList span.name {font-weight: bold;color: #010101;font-size: 1.2em;}
/* @media all and (min-width:320px) {
dl.resultList a span.facultyInfo  {  min-width: 138px;   }
}
 
@media all and (min-width:360px) {
dl.resultList a span.facultyInfo  {  min-width:170px;    }
}

@media all and (min-width:414px) {
dl.resultList a span.facultyInfo  {  min-width:200px;    }
} */
</style>
<div id="fixedTop">

	<!-- container -->
	<div id="containerWrap">
		<?if(!$glanceYN){?>
		<div class="titArea">
			<h2><?=$setting_col['invited_speaker']?></h2>
			<p class="fixedBtn">
				<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
			
			</p>
		</div>
		<?}?>
	</div>


</div>

<?
$query = "select * from faculty_tbl where name not in ('','-') and code='".$code."' and viewYN='Y' and invitedYN='Y' and del='N'";

$query .= " order by name asc";
$result = mysqli_query($conn, $query);
?>
<div class="contents">

	<ul class="facultyList">
	<?while(is_array($col = mysqli_fetch_array($result))){?>
		<li><a href="./../session/list.php?tab=-5&code=<?=$code?>&sid=<?=$col['sid']?>&glanceYN=<?=$glanceYN?>&deviceid=<?=$deviceid?>">
			<span class="photo">
		<?
		if($col['photo']){?><span><img src="/upload/faculty/<?=$col['photo']?>" ></span>
		<?}else if($setting_col['faculty_def_image']){?>
			<span><img src="/upload/faculty/<?=$setting_col['faculty_def_image']?>" alt=""></span>
		<?}?></span>
			<span class="name"><?=$col['name']?></span>
			<?
			if($setting_col['faculty_txt_type']=="2"){?>
			<?="(".$col['office'].")"?>
			<?}else if($setting_col['faculty_txt_type']=="3"){?>
			<?="(".$col['office'].", ".$col['country'].")"?>
			<?}?>
			</a>
		</li>
	<?}?>
	
	</ul>

</div>

<?include "./../footer.php";?>