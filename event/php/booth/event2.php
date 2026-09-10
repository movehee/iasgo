<?include "./../header.php";?>

<?
$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);




$query = "SELECT a.image,b.sid,b.signdate FROM booth_tbl a left join booth_event_tbl b  on a.sid = b.booth_sid and b.user_sid='".$barcode."' where a.code='".$code."' and a.del='N' and a.tab in ('1','2') ";	


$query .= " order by b.sid desc, a.vip asc, a.orderby desc";
$result = mysqli_query($conn, $query);
$vip=-1;
//echo $query;
?>
<meta name="viewport" content="user-scalable=no" />
<style>

ul.itemList {overflow: hidden;    padding: 0;padding-top: 10px;list-style: none;}
ul.itemList li {float: left;width: 50%;padding: 0 0 10px 5px;box-sizing:border-box;}
ul.itemList li:nth-child(odd) {padding: 0 5px 10px 0;}
ul.itemList div {position: relative;overflow: hidden;height: 140px;padding: 10px;border: 1px solid #c9ccd4;}
ul.itemList span {display: block;}
ul.itemList div > img {position: absolute;left: 50%;top: 50%;width: 320px;height: 160px;margin:-80px 0 0 -160px;}

ul.itemList li div > span {position:relative;border: 2px solid #fff;border-radius:2px;}
ul.itemList li div > span span {margin: 3px;border: 1px dashed #fff;border-radius:2px;text-align: center;}
ul.itemList li div > span img {width: 172px;height: 110px;padding: 7px 0;}


ul.itemList li.comp div {background-color: #33136e;}
ul.itemList li.comp div > img {opacity: 0.1;}


</style>





<ul class="itemList">
	<?while(is_array($col = mysqli_fetch_array($result))){?>

		<li <?if($col['sid']){?> class="comp"<?}?>><div>
		
			<span><span><img src="/image/booth_comp.png" alt=""></span></span>
			<img src="/upload/booth/<?=$col['image']?>" alt="SANOFI" />
		</div></li>



	<?}?>
	
</ul>



<?include "./../footer.php";?>