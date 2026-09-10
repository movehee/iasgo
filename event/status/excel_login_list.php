<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.225'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=login_list_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
	$query = "select * from registration_tbl where login_day".$ev_date.">0 and member_level!='M' and classification not in ('C','M','Y')";
	$result = $conn->query($query);
    $rows = $result->numRows();
?>
<table border=1>
    <thead>
        <tr>
            <th>No</th>
            <th>Country</th>
            <th>Name</th>
            <th>Affiliation</th>
            <th>Device</th>
        </tr>
    </thead>
    <?
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
    ?>
    <tr>
        <td><?=$rows--?></td>
        <td><?=$d['etc_field1']?></td>

        <?if($d['country'] == "F"){?>
            <td><?=$d['name_eng']?></td>
            <td><?=stripslashes($d['aff_eng'])?></td>
        <?}else{?>
            <td><?=$d['name_kr']?></td>
            <td><?=$d['aff_kor']?></td>
        <?}?>
        <td><?=$_Login['login_kind'][$d['login_kind']]?></td>
    </tr>
    <?}?>
</table>
