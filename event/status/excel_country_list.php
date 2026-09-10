<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.225'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=country_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
	$query = "select etc_field1,Tcnt from (";
    $query .= "select etc_field1,count(etc_field1) as Tcnt from registration_tbl where login_day".$ev_date.">0 and etc_field1 is not null and etc_field1!='' and del='N' and member_level!='M' and classification not in ('C','M','Y') group by etc_field1 ";
    $query .= ") A order by Tcnt desc";
	$result = $conn->query($query);
    $rows = $result->numRows();
?>
<table border=1>
    <thead>
        <tr>
            <th>No</th>
            <th>Country</th>
            <th>Count</th>
        </tr>
    </thead>

			
    <?
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
    ?>
    <tr>
        <td><?=$rows--?></td>
        <td><?=$d['etc_field1']?></td>
		<td><?=$d['Tcnt']?></td>
    </tr>
    <?}?>
</table>
