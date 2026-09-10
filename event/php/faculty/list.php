<?include "./../header.php";?>
<?
	$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
	$setting_result = mysqli_query($conn, $setting_query);
	$setting_col = mysqli_fetch_array($setting_result);

if($setting_col['faculty']){
	$title=$setting_col['faculty'];
}else{
	$title="faculty";
}


function utf8_strlen($str) { return mb_strlen($str, 'UTF-8'); }
function utf8_charAt($str, $num) { return mb_substr($str, $num, 1, 'UTF-8'); }

function cho_hangul($str) {
  $cho = array("ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ");
  $result = "";

    $code = utf8_ord(utf8_charAt($str, 0)) - 44032;
    if ($code > -1 && $code < 11172) {
      $cho_idx = $code / 588;      
      $result .= $cho[$cho_idx];
    }
  
  return $result;
}


?>
<style>
dl.resultList ul.withFavor > li {position: relative;padding:10px 65px 10px 0;}
dl.resultList ul.withFavor a.favor {position: absolute;right: 20px;top: 50%;margin-top: -14px;}
dl.resultList a.photo {    overflow: hidden; position: relative;padding: 5px 15px 5px 15px;}
/*dl.resultList a.photo span  {overflow: hidden;position: relative;left: 15px;top: 50%;width: 28px;height: 28px;margin-top: -15px;border: 1px solid #ddd;border-radius:14px;} */
dl.resultList a.photo span {overflow: hidden; width: 60px; display: inline-block; vertical-align: middle;height: 60px; margin-right:10px; border: 1px solid #ddd; border-radius: 50%;}
dl.resultList a span.facultyInfo {    width: auto; border-radius:0; border:none; display: inline-block;   overflow: hidden;   vertical-align: middle;  height: auto;     line-height: 16px;}

dl.resultList a span.facultyInfo dl > dt,dl {display: inline;}
dl.resultList a span.facultyInfo dl > dt {font-weight: bold;color: #010101;font-size: 1.2em;}

dl.resultList a.photo span img {width: 100%;height: 100%;background-size:cover;}
a.favor,
a.favorTxt {height:15px;font-size:9px;padding:6px 3px!important; background:transparent; }
a.favor i,
a.favorTxt i {display:block;text-align:center;}
a.favor.on,
a.favorTxt.on {  border:1px solid #ffb020;background-color:#ffb020;color:#fff !important;}

ul.facultyList {overflow: hidden;padding:45px 10px 10px;}
ul.facultyList li {float: left;width: 50%;padding: 10px 0 0 5px;box-sizing:border-box;}
ul.facultyList li:nth-child(odd) {clear: both;padding: 10px 5px 0 0;}
ul.facultyList a {color: #282828;width:100%!important;}
ul.facultyList span {display: block;}
ul.facultyList span.photo { overflow: hidden;height: 210px;border: 1px solid #c9ccd4;margin-bottom: 5px;background: #fff url('/image/faculty_thumb.jpg') center center no-repeat;background-size: 75px;}
 
ul.facultyList span.photo img {display: block;width: 100%;height: 100%;}
ul.facultyList span.name {font-weight: bold;color: #010101;font-size: 1.2em;}

ul.facultyList dl > dt,dl {display: inline;}
ul.facultyList dl > dt {font-weight: bold;color: #010101;font-size: 1.2em;}

/* 
@media all and (min-width:320px) {
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
		
		<div class="titArea">
			<h2><?=$title?></h2>
			<p class="fixedBtn">
				<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
			
			</p>
		</div>
	</div>
<?if($setting_col['faculty_view_type']=="1"){?>
<div class="searchArea">
		<form id="" name="" action="./list.php" method="post">
			<fieldset>
				<legend>Search</legend>
				<input type="hidden" name="tab" value="<?=$tab?>">
				<input type="hidden" name="code" value="<?=$code?>">
				<input type="hidden" name="deviceid" value="<?=$deviceid?>">
				<input type="hidden" name="toptext" value="<?=$toptext?>">
				<input type="text" name="search" id="search" value="<?=$search?>" placeholder="Please enter keywords">
				<button class="search"><i class="fab fa-sistrix" title="검색"></i></button>
			</fieldset>
		</form>		
	</div>
	<?if($code=="kddw2019"){?>
	<p align="right"><font color="#1a3796">List in first name order &nbsp;&nbsp;</font></p>
	<?}?>
<?}?>
<p id="goTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>

</div>

<?
if($setting_col['faculty_view_type']=="1"){
include "./type1.php";
}else if($setting_col['faculty_view_type']=="2"){
include "./type2.php";
}
?>



<?include "./../footer.php";?>