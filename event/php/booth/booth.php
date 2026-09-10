<?include "./../header.php";?>

<?
$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

$query = "SELECT * FROM booth_tbl where code='".$code."' and del='N'";
$query .= " and tab in ('1','3') ";	
$query .= " order by vip asc, orderby asc";
$result = mysqli_query($conn, $query);
$vip=-1;
?>
<style>
div.sponsors > dd {text-align:center;    padding: 10px;}
div.sponsors dd.vip1 img {width:<?=$setting_col['vip_width1']?>%!important;}
div.sponsors dd.vip2 img {width:<?=$setting_col['vip_width2']?>%!important;}
div.sponsors dd.vip3 img {width:<?=$setting_col['vip_width3']?>%!important;}
div.sponsors dd.vip4 img {width:<?=$setting_col['vip_width4']?>%!important;}
div.sponsors dd.vip5 img {width:<?=$setting_col['vip_width5']?>%!important;}
div.sponsors dd.vip6 img {width:<?=$setting_col['vip_width6']?>%!important;}

div.sponsors > dd.boothNo{display:block;color: #ffffff; position: absolute; top:0; left:0;background-color: #383838;padding: 10px; 20px; font-size:25px;}
div.sponsors > dd img {width:145px;margin:5px 0 5px 5px;}
div.sponsors > dd img { border: 1px solid #efefef;}
/* div.sponsors > dd img:first-child {margin-left:0;}
 */
</style>

<?if(!$include){?>
<div class="titArea">
	<h2><?=$setting_col['sponsor_txt']?></h2>
	<p class="fixedBtn">
		<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		
	</p>
</div>
<?}?>


<div class="sponsors">

<?if($setting_col['booth_ui_type']=="1"){?>
</dd>
<?}?>
<?while(is_array($col = mysqli_fetch_array($result))){
	if($setting_col['booth_ui_type']=="1"){
		if($vip!= $col['vip']){
			
			$vip = $col['vip'];?>
			</dd>
			<li style="width:100%;height:35px;line-height:35px;text-align:center;background-color:<?=$setting_col['vip_color'.$vip]?>;color:#fff"><?=$setting_col['vip_info'.$vip]?></li>
			<dd class="vip<?=$vip?>">
		<?}
	?>
	<?if($col['image']){?>
	<img src="http://ezv.kr/upload/booth/<?=$col['image']?>" <?if($col['linkurl']){?> onclick="javascript:location.href='<?=$col['linkurl']?>'"<?}?> alt="" />
	<?}else{?>
	<img style="border: 0px solid #efefef;"/>
	<?}?>
	<?}else if($setting_col['booth_ui_type']=="2"){?>
		<li style="width:33.3%;background-color:#fff;"><img style="width:100%" <?if($col['linkurl']){?> onclick="javascript:location.href='<?=$col['linkurl']?>'"<?}?> src="http://ezv.kr/upload/booth/<?=$col['image']?>" ></li>
	<?}?>
<?}?>

</div>


<?include "./../footer.php";?>