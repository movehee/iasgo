<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=day_count".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
	$query = "select * from room_statistics_tbl where day='$chkday' order by signdate desc";
	$result = $conn->query($query);
    $rows = $result->numRows();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border=1>
    <thead>
        <tr>
            <th rowspan=2>No</th>
            <th colspan=2>Login</th>
            <?foreach($_CONFIG['room'] as $tkey=>$tval){?>
			<?if($chkday=='1') if($tkey!='1' && $tkey!='3' && $tkey!='5' && $tkey!='9') continue;?>
			<?if($chkday!='1')if($tkey!='1'  && $tkey!='3' && $tkey!='5' ) continue;?>
            <th colspan=2><?=$_Day['room_title'][$tkey]?></th>
            <?}?>
            <th rowspan=2>저장일</th>
        </tr>
        <tr>
            <th>국내</th>
            <th>국외</th>
            <?foreach($_CONFIG['room'] as $tkey=>$tval){?>
			<?if($chkday=='1') if($tkey!='1' && $tkey!='3' && $tkey!='5' && $tkey!='9') continue;?>
			<?if($chkday!='1')if($tkey!='1'  && $tkey!='3' && $tkey!='5' ) continue;?>
            <th>국내</th>
            <th>국외</th>
            <?}?>
        </tr>
    </thead>

			
    <?
    $n=1;
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
    ?>
    <tr>
        <td><?=$n++;?></td>
        <td><?=$d['login_K']?></td>
        <td><?=$d['login_F']?></td>
        <?foreach($_CONFIG['room'] as $tkey=>$tval){?>
		<?if($chkday=='1') if($tkey!='1' && $tkey!='3' && $tkey!='5' && $tkey!='9') continue;?>
		<?if($chkday!='1')if($tkey!='1'  && $tkey!='3' && $tkey!='5' ) continue;?>
        <td><?=$d['room'.$tkey.'_kor']?></td>
        <td><?=$d['room'.$tkey.'_eng']?></td>
        <?}?>
        <td><?=date('y.n.j H:i',$d['signdate'])?></td>
    </tr>
    <?}?>
</table>
