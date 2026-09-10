<?include "./../header.php";?>
<table style="width:100%">
<tr>
<?
$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


if($setting_col['photo_order']=="2"){
	$orderby = " order by cnt desc, a.signdate desc, a.idx asc ";
}else if($setting_col['photo_order']=="1"){
	$orderby = " order by a.signdate desc, a.idx asc ";
}


if($setting_col['photo_type']=="1"){

	$query = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.code='".$code."'";
	$query .= " and a.del='N'";
	$query .= " and a.tab='".$tab."' group by a.sid";
	$query .= $orderby;
	$result = mysqli_query($conn, $query);
	while($row = mysqli_fetch_array($result)){?>
	<li style="float:left;width:25%;background-color:#fff;"><img style="height:100px;width:100%" src="/upload/photo/<?=$row['url']?>" ></li>
	
	<?
	}


}else if($setting_col['photo_type']=="2"){

	$cnt_query="SELECT count(*) cnt FROM photo_tbl where code='".$code."' and tab='".$tab."' and del='N'";
	$cnt_result = mysqli_query($conn, $cnt_query);
	$cnt_d = mysqli_fetch_array($cnt_result);

	$cnt = ($cnt_d['cnt'] - ($cnt_d['cnt'] % 5)) / 5;
	if(($cnt_d['cnt'] % 10) > 0 && ($cnt_d['cnt'] % 10) < 5){
		$cnt++;
	}

	$query = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.code='".$code."'";
	$query .= " and a.del='N'";
	$query .= " and a.tab='".$tab."' group by a.sid ";
	$query .= $orderby;
	$query .= " limit ".$cnt;
	//echo $query;

	$result = mysqli_query($conn, $query);


	$query2 = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.code='".$code."'";
	$query2 .= " and a.del='N'";
	$query2 .= " and a.tab='".$tab."' group by a.sid ";
	$query2 .= $orderby;
	$query2 .= " limit  ".$cnt.",".$cnt_d['cnt'];

	//echo $query2;

	$result2 = mysqli_query($conn, $query2);

	$cnt=0;
	while($row2 = mysqli_fetch_array($result2)){

		if($cnt==0){
			?>
			</tr><tr>
			<?
			$row = mysqli_fetch_array($result);
			if($row){
			?>
		<td  rowspan='2' colspan='2'><img style="height:200px;width:100%" src="/upload/photo/<?=$row['url']?>" ></td>
		<?
			}
		}
		if($cnt==2){?></tr><tr><?
		}
		if($cnt==4){?></tr><tr><?
		}
		if($cnt==6){
			$row = mysqli_fetch_array($result);
			if($row){
			?>
		<td rowspan='2' colspan='2'><img style="height:200px;width:100%" src="/upload/photo/<?=$row['url']?>" ></td>
		</tr><tr>
		<?
			}
		}
		$cnt++;
		if($cnt==8){
			$cnt=0;
		}?>
		<td><img style="height:100px;width:100%" src="/upload/photo/<?=$row2['url']?>" ></td>
		<?
	}
}
?>
</tr>
</table>

<?include "./../footer.php";?>