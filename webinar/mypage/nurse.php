<?
	$Nurse_name = $conn->getOne("select if(name_eng!='',name_eng,name_kr) from registration_tbl where sid='".$_COOKIE['wmember_sid']."'");
?>
<style type="text/css">
#popupCertificate {position: relative;width: 1000px;font-family: 'Roboto-Regular', sans-serif;}
#popupCertificate div.bg {}
#popupCertificate img {display: block;width: 100%;}

.name {position: absolute;top: 457px;left: 376px; width:579px; color: #000;text-align: center;font-size: 60px;font-family: 'times new roman';}
</style>
<div class="contentArea">
	<div class="ac" style="width:100%;padding:20px;text-align:center;padding-left:150px;">
		<div id="popupCertificate">
			<div class="bg"><img src="/asset/layout/certificate_bg.png" alt="CERTIFICATE OF ATTENDANCE"></div>
			<div class="name"><?=$Nurse_name?></div>
		</div>
	</div>
</div>

<div class="btnArea">
	<a href="javascript:popup_call('print/nurse','')" class="btnPrint">Certificate Print</a>
</div>