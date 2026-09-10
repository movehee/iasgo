<?

if($abstract_num) {
	include_once $_SERVER['DOCUMENT_ROOT']."/php/abstract/$code/config.php";
	
	echo '<h3 class="dayInfo2">Abstract</h3><ul class="subjectList">';
	
	$abstract_sids = implode(",", $abstract_sid_arr);

	$abs_query = "select * from abstract_tbl where sid in ($abstract_sids)";
	$abs_result = $local_conn->query($abs_query);
	if(DB::isError($abs_result)) {
		die($abs_result->getMessage());
	}

	while(is_array($abs_col = $abs_result->fetchRow(DB_FETCHMODE_ASSOC))) {

		##발표자 책임저자 등록
		$pname="";
		$cname="";
		for($j=1;$j<=$abs_col['author_cnt']*1;$j++){$k=$j-1;
			$author_query = "select * from abstract_author where asb_num='".$abs_col['sid']."' and orders='".$j."'";
			$author_result = $local_conn->query($author_query);
			if(DB::isError($author_result)) {
				die($author_result->getMessage().'author_query');
			}

			$author_col = $author_result->fetchRow(DB_FETCHMODE_ASSOC);		//  $row 배열에 입력시킨다.
			
			?>
			<!--<?=$j>1?', ':''?><?=$author_col['first_name'].' '.$author_col['last_name']?><sup><?=$author_col['affilation']?></sup>-->
			<?
			$author_type = explode(',',$author_col['type']);
			if(in_array('1',$author_type)){
				$pname=$author_col['first_name'].' '.$author_col['last_name'];
				//echo '<sup>*</sup>';
			}

			if(in_array('2',$author_type)){
				$cname=$author_col['first_name'].' '.$author_col['last_name'];
				//echo '<sup>†</sup>';
			}
		}
?>
	
		
		<li class="mySchedule">
			<a href="./../abstract/view.php?code=<?=$code?>&deviceid=<?=$deviceid?>&sid=<?=$abs_col['sid']?>">

			<span class="sessionCode">[<?=$abs_col['abs_no']?>]</span>
			<span class="sessionTit"><?=!empty($abs_col['title_eng'])?$abs_col['title_eng']:$abs_col['title_kor']?></span>
			<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$pname?></span>
			</a>

			<p class="btn btnDel"><a onclick="javascript:favor_del(this,'<?=$abs_col['sid']?>','<?=$deviceid?>','<?=$code?>','abstract')"><i class="far fa-trash-alt" title="Venue"></i></a></p>
			
		</li>
<?			
	}

	echo "</ul>";
}

?>

<style>
li.mySchedule {position:relative}
li.mySchedule p.btnDel {z-index: 50;position: absolute;right: 0;bottom: 1px;}
li.mySchedule p.btnDel a {padding: 15px;font-size: 16px;border-color:#fff}
</style>