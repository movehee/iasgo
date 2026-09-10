<?include "./../header.php";?>

<?
$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

$query = "SELECT * FROM booth_tbl where code='".$code."' and del='N'";
if(!$tab)
$tab=1;

if($tab==1){
	$query .= " and tab in ('1','3') ";	
}else if($tab==2)
{
$query .= " and tab in ('2') ";	
}
$query .= " order by vip asc, orderby asc";
//echo $query;
$result = mysqli_query($conn, $query);
$vip=-1;
?>
<style>
ul.booth {overflow:hidden;padding:0 10px 10px;list-style: none;}
ul.booth li {float:left;width:50%;padding-top:10px;box-sizing:border-box;}
ul.booth li:nth-child(odd) {padding-right:5px;}
ul.booth li:nth-child(even) {padding-left:5px;}

ul.booth a {position:relative;display:block;border:1px solid #cdcdcd;}
ul.booth img {display:block;width:100%;}
 
ul.booth span {display:none;position:absolute;left:0;top:0;width:100%;height:100%;text-indent:-10000px;background:rgba(0,0,0,.7) url('/image/booth_checked.png') center center no-repeat;background-size:31%;}


ul.booth li.on span {display:block;}
ul.booth li .checktime{display:none;color:#ffffff; width: 100%; position: absolute; text-align: center; top: 80%;text-indent: 0;  background: none;}
ul.booth li .boothNo{display:block;color: #ffffff; position: absolute; top:0; left:0;background-color: #383838;padding: 4px; 10px; font-size:9px;}
 
ul.booth li.on .checkbg,
ul.booth li.on .checktime {display:block;}
</style>

<?if(!$include){?>
<div class="titArea">
	<h2><?=$setting_col['sponsor_txt']?></h2>
	<p class="fixedBtn">
		<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		
	</p>
</div>
<?}?>


<ul class="booth">
	<?while(is_array($col = mysqli_fetch_array($result))){?>
	
		<li><a href="<?=$col['linkurl'] == "" ? "javascript:void(0)" : $col['linkurl']?>">
			<img src="http://ezv.kr/upload/booth/<?=$col['image']?>" alt="SANOFI" />
			
			<?if($code=="koa2019s"){?>
				<div class="boothNo"><?=$col['id']?></div>
			<?}?>
			

		</a></li>
	<?}?>
	
</ul>



<?include "./../footer.php";?>