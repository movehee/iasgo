<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$ex_fname = explode("_",$fname);
	if($type=='broc'){
		$query = "select * from booth_brochures where sid='$sid'";
		$result = $conn->query($query);
		$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
		$result->free();

		if($fkind=='cover'){
			$filename = $d['cover_file'];	
		}else if($fkind=='broc'){
			$filename = $d['broc_file'];	
		}
	}else if($type=='movie'){
		$query = "select * from booth_movie where sid='$sid'";
		$result = $conn->query($query);
		$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
		$result->free();

		$filename = $d['movie_file'];
	}else if($type=='logo_file' || $type=='booth_file' || $type=='front_file1' || $type=='front_file2' || $type=='front_file3' || $type=='front_file4' || $type=='booth_ground_file' || $type=='stamp_file' || $type=='booth_bottom_file'){
		$query = "select * from booth where sid='$sid'";
		$result = $conn->query($query);
		$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
		$result->free();

		$filename = $d[$type];
	}
	$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/booth/" . $filename) . "&filename=" . base64_encode($filename);
	$conn->disconnect();
?>
<div class="<?=$fkind?>_<?=$d['sid']?>">
	<img src="<?=IconType3($filename)?>" onclick="location.href='/func/download.php?<?=$queryString?>'"class="hand" width=20 height=20>
	<?if($type=='logo_file' && $type=='booth_file' && $type=='front_file1' && $type=='front_file2' && $type=='front_file3' && $type=='front_file4' && $type=='booth_ground_file'  && $type=='stamp_file' && $type=='booth_bottom_file'){?>
	<span><img src="/image/icon/icon_del.png" onclick="common_delete_file(<?=$d['sid']?>,'<?=$type?>_file','<?=$fkind?>')" class="hand"></span>
	<?}?>
</div>
